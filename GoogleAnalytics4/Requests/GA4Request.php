<?php

namespace ScAnalytics\GoogleAnalytics4\Requests;

use JsonException;
use JsonSerializable;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AParameter;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4Parameter;
use ScAnalytics\GoogleAnalytics4\GoogleAnalytics4;

/**
 * Class GA4Request. Represents a basic request to the Google Analytics 4 API.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference?client_type=gtag Protocol Reference
 */
class GA4Request extends ARequest implements JsonSerializable
{

    /**
     * @var string The URL to the Google Analytics 4 endpoint
     */
    private static $ENDPOINT = "https://www.google-analytics.com/mp/collect";

    /**
     * @var string The URL to the Google Analytics 4 debug endpoint
     */
    private static $DEBUG_ENDPOINT = "https://www.google-analytics.com/debug/mp/collect";

    /**
     * @var GA4Event[] A list of events in this request
     */
    private $events = [];

    /**
     * @var array<string, mixed> A key-value-map of all parameters
     */
    private $parameters = [];

    /**
     * GARequest constructor. Initializes default parameters.
     * <b>Automatically enables debug mode based on the environment!</b>
     */
    public function __construct()
    {
        parent::__construct();
        $scope = Analytics::getScope();

        try {
            $this->setParameter(GA4Parameter::$CLIENT_ID, GoogleAnalytics4::getClientID());
            if ($scope->hasAnalyticsConsent() && !is_null($scope->getUserId())) {
                $this->setUserIdentifier($scope->getUserId());
            }
            $this->setParameter(GA4Parameter::$NON_PERSONALIZED_ADS, !$scope->hasAnalyticsConsent());
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
            $this->setParameter(GA4Parameter::$USER_ID, $userId);
        } catch (JsonException $ignored) {
        }
    }

    /**
     * @inheritDoc
     */
    public function updateGenerationTime(): void
    {
        // TODO: Implement updateGenerationTime() method.
    }

    /**
     * Adds a new event to a request. A maximum of 25 events are allowed;
     *
     * @param GA4Event $event An event to add to this request
     * @return $this This instance
     */
    public function addEvent(GA4Event $event): GA4Request
    {
        if (count($this->events) < 25) {
            $this->events[] = $event;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setParameter(AParameter $key, $value): void
    {
        if (is_null($value)) {
            unset($this->parameters[$key->getName()]);
        } else {
            $this->parameters[$key->getName()] = $value;
        }
    }

    /**
     * @return array<string, mixed> A key-value-map of all parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @inheritDoc
     */
    public function send(): bool
    {
        if (empty(AnalyticsConfig::$googleAnalytics4)) {
            return false;
        }
        foreach (AnalyticsConfig::$googleAnalytics4 as $key => $secret) {
            $params = [
                'api_secret' => $secret,
                'measurement_id' => $key
            ];
            try {
                $content = json_encode($this, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                return false;
            }

            $user_agent = "SC-Analytics by Promatur (" . HelperFunctions::getDomain() . "/";
            if (!empty(AnalyticsConfig::$version)) {
                $user_agent .= " v" . AnalyticsConfig::$version;
            }
            $user_agent .= ")";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_URL, ($this->isDebug() ? self::$DEBUG_ENDPOINT : self::$ENDPOINT) . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            $result = curl_exec($ch);
            $errors = curl_error($ch);
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            var_dump($content);

            $success = $this->requestSuccessful($result, $errors, $response);
            if (!$success) {
                var_dump($content);
                var_dump($result);
                var_dump($errors);
                var_dump($response);
                $debug = $this->isDebug();
                $query = ($this->isDebug() ? self::$DEBUG_ENDPOINT : self::$ENDPOINT);
                if (function_exists('\Sentry\configureScope')) {
                    \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($debug, $result, $errors, $response, $content, $query, $key): void {
                        $scope->setLevel(\Sentry\Severity::warning());
                        $scope->setExtra('Debug', $debug);
                        $scope->setExtra('Payload', $content);
                        $scope->setExtra('Measurement ID', $key);
                        $scope->setExtra('Result', $result);
                        $scope->setExtra('Errors', $errors);
                        $scope->setExtra('Response Code', $response);
                        $scope->setExtra('Query', $query);
                        \Sentry\captureMessage("Error sending Google Analytics 4 request.");
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
        if (is_numeric($responseCode) && ($responseCode !== 204 && $responseCode !== 200)) {
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
            if (!array_key_exists("validationMessages", $json)) {
                return false;
            }
            if (!empty($json['validationMessages'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $parameters = $this->getParameters();
        $parameters[GA4Parameter::$EVENTS->getName()] = $this->events;
        return $parameters;
    }
}