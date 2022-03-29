<?php


namespace ScAnalytics\GoogleAnalytics\Requests;

use JsonException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\GoogleAnalytics;

/**
 * Class GARequest. Represents a basic request to the Google Analytics API.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
 */
class GARequest extends ARequest
{

    /**
     * @var string The URL to the Google Analytics endpoint
     */
    private static $ENDPOINT = "https://www.google-analytics.com/collect";
    /**
     * @var string The URL to the Google Analytics debug endpoint
     */
    private static $DEBUG_ENDPOINT = "https://www.google-analytics.com/debug/collect";
    /**
     * @var string The version of Google Analytics
     */
    private static $VERSION = "1";

    /**
     * GARequest constructor. Initializes default parameters.
     * <b>Automatically enables debug mode based on the environment!</b>
     */
    public function __construct()
    {
        parent::__construct();
        $scope = Analytics::getScope();

        try {
            $this->setParameter(GAParameter::$VERSION, self::$VERSION);
            $this->setParameter(GAParameter::$CLIENTID, GoogleAnalytics::getClientID());
            if ($scope->hasAnalyticsConsent() && !is_null($scope->getUserId())) {
                $this->setUserIdentifier($scope->getUserId());
            }
            $this->setParameter(GAParameter::$USERIP, HelperFunctions::getIpAddress());
            $this->setParameter(GAParameter::$USERAGENT, $_SERVER['HTTP_USER_AGENT'] ?? null);
            $this->setParameter(GAParameter::$USERLANGUAGE, $scope->getLanguage());
            $this->setParameter(GAParameter::$NOPERSONALIZATION, !$scope->hasAnalyticsConsent());
            $this->setParameter(GAParameter::$ANONYMIZEIP, true);
            $this->setParameter(GAParameter::$REFERRER, $_SERVER['HTTP_REFERER'] ?? null);
            $this->setParameter(GAParameter::$DATASOURCE, "web");
            $this->setParameter(GAParameter::$CACHEBUSTER, mt_rand());
            $this->setParameter(GAParameter::$DOCUMENTLOCATION, HelperFunctions::getURL());
            $this->setParameter(GAParameter::$DOCUMENTPATH, $_SERVER['REQUEST_URI'] ?? null);
            $this->setParameter(GAParameter::$DOCUMENTHOST, $_SERVER['SERVER_NAME'] ?? null);
            $this->setParameter(GAParameter::$CAMPAIGNNAME, $_GET['utm_campaign'] ?? null);
            $this->setParameter(GAParameter::$CAMPAIGNSOURCE, $_GET['utm_source'] ?? null);
            $this->setParameter(GAParameter::$CAMPAIGNMEDIUM, $_GET['utm_medium'] ?? null);
            $this->setParameter(GAParameter::$CAMPAIGNKEYWORD, $_GET['utm_keyword'] ?? null);
            $this->setParameter(GAParameter::$CAMPAIGNCONTENT, $_GET['utm_content'] ?? null);
            $this->setParameter(GAParameter::$APPNAME, HelperFunctions::getDomain());
            $this->setParameter(GAParameter::$APPVERSION, AnalyticsConfig::$version);
        } catch (JsonException $e) {
            if (function_exists('\Sentry\captureException')) {
                /** @noinspection PhpFullyQualifiedNameUsageInspection */
                \Sentry\captureException($e);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function setUserIdentifier(?string $userId): void
    {
        try {
            $this->setParameter(GAParameter::$USERID, $userId);
        } catch (JsonException $ignored) {
        }
    }

    /**
     * Valid values are 'pageview', 'screenview', 'event', 'transaction', 'item', 'social', 'exception', 'timing'.
     *
     * @param string $type The name of the hit type
     */
    public function setType(string $type): void
    {
        try {
            $this->setParameter(GAParameter::$TYPE, $type);
        } catch (JsonException $ignored) {
        }
    }

    /**
     * @inheritDoc
     */
    public function send(): bool
    {
        if (empty(AnalyticsConfig::$googleAnalyticsIDs)) {
            return false;
        }
        foreach (AnalyticsConfig::$googleAnalyticsIDs as $key) {
            try {
                $this->setParameter(GAParameter::$TRACKINGID, $key);
            } catch (JsonException $ignored) {
            }
            $parameters = $this->getParameters();
            ksort($parameters);
            $content = http_build_query($parameters);
            $content = utf8_encode($content);
            $user_agent = "SC-Analytics by Promatur (" . HelperFunctions::getDomain() . "/";
            if (!empty(AnalyticsConfig::$version)) {
                $user_agent .= " v" . AnalyticsConfig::$version;
            }
            $user_agent .= ")";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_URL, $this->isDebug() ? self::$DEBUG_ENDPOINT : self::$ENDPOINT);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            $result = curl_exec($ch);
            $errors = curl_error($ch);
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $success = $this->requestSuccessful($result, $errors, $response);
            if (!$success) {
                $debug = $this->isDebug();
                $query = ($this->isDebug() ? self::$DEBUG_ENDPOINT : self::$ENDPOINT) . "?" . $content;
                if (function_exists('\Sentry\configureScope')) {
                    \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($debug, $result, $errors, $response, $parameters, $query): void {
                        $scope->setLevel(\Sentry\Severity::warning());
                        $scope->setExtra('Debug', $debug);
                        $scope->setExtra('Parameters', $parameters);
                        $scope->setExtra('Result', $result);
                        $scope->setExtra('Errors', $errors);
                        $scope->setExtra('Response Code', $response);
                        $scope->setExtra('Query', $query);
                        \Sentry\captureMessage("Error sending Google Universal Analytics request.");
                    });
                }
                return false;
            }
        }
        return true;
    }

    /**
     * Evaluates the results by the curl request to determine, if it was successful.
     *
     * @param bool|string $result The result received by the Google Analytics API
     * @param string $errors Errors returned by the request
     * @param mixed $responseCode The HTTP response code
     * @return bool True, if the request has been evaluated as successful
     */
    private function requestSuccessful($result, string $errors, $responseCode): bool
    {
        if (is_bool($result) && !$result) {
            return false;
        }
        if (is_numeric($responseCode) && $responseCode !== 200) {
            return false;
        }
        if (!empty($errors)) {
            return false;
        }
        if (is_string($result) && !empty($result) && $this->isDebug()) {
            try {
                $json = json_decode($result, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                return false;
            }
            if (!is_array($json)) {
                return false;
            }
            if (!array_key_exists("hitParsingResult", $json)) {
                return false;
            }
            if (!$json['hitParsingResult'][0]['valid']) {
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function updateGenerationTime(): void
    {
        if (isset($GLOBALS["start_time"])) {
            try {
                $this->setParameter(GAParameter::$LOADTIME, round((microtime(true) - $GLOBALS["start_time"]) * 1000));
            } catch (JsonException $ignored) {
            }
        }
    }
}