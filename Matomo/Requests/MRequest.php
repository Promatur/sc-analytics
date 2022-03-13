<?php


namespace ScAnalytics\Matomo\Requests;


use JsonException;
use RuntimeException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Matomo\Matomo;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MRequest. Represents a basic request to the Matomo API.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developer.matomo.org/api-reference/tracking-api Parameter documentation
 */
class MRequest extends ARequest
{

    /**
     * @var string The API version of Matomo
     */
    private const VERSION = "1";

    /**
     * @var string|null Six character unique ID, which is different for each page view
     */
    private static $pageViewID;

    /**
     * @var array[] An array of custom variables
     */
    private $customVariables = [];

    /**
     * MRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $scope = Analytics::getScope();
        try {
            $this->setParameter(MParameter::$SITEID, AnalyticsConfig::$matomoID);
            $this->setParameter(MParameter::$REC, true);
            $this->setParameter(MParameter::$URL, rtrim(HelperFunctions::getURL(), '/'));
            $this->setParameter(MParameter::$RAND, mt_rand());
            $this->setParameter(MParameter::$APIVERSION, self::VERSION);
            $this->setParameter(MParameter::$VISITORID, Matomo::getVisitorId());

            $this->setParameter(MParameter::$REFERRER, $_SERVER['HTTP_REFERER'] ?? null);
            $this->setParameter(MParameter::$CAMPAIGNNAME, $_GET['utm_campaign'] ?? null);
            $this->setParameter(MParameter::$CAMPAIGNKEYWORD, $_GET['utm_keyword'] ?? null);
            $this->setParameter(MParameter::$HOUR, date("H"));
            $this->setParameter(MParameter::$MINUTE, date("i"));
            $this->setParameter(MParameter::$SECOND, date("s"));
            if (!empty($_COOKIE)) {
                $this->setParameter(MParameter::$COOKIES, true);
            }
            $this->setParameter(MParameter::$USERAGENT, $_SERVER['HTTP_USER_AGENT'] ?? null);
            $this->setParameter(MParameter::$LANGUAGE, $scope->getLanguage());
            foreach ($scope->getCustomDimensions() as $index => $value) {
                $this->setParameter(MParameter::$CUSTOMDIMENSION->withValue($index), $value);
            }
            if ($scope->hasAnalyticsConsent() && !empty($scope->getUserId())) {
                $this->setUserIdentifier($scope->getUserId());
            }
            if (session_status() === PHP_SESSION_ACTIVE) {
                $this->setParameter(MParameter::$CLIENTID, substr(str_replace("-", "", $scope->getClientId() ?? ""), 0, Matomo::LENGTH_VISITOR_ID));
            }
            $this->setParameter(MParameter::$PAGEVIEWID, self::$pageViewID);
            if ($this->isDebug()) {
                $this->setParameter(MParameter::$QUEUEDTRACKING, false);
            }
            $this->setParameter(MParameter::$SENDIMAGE, false);
            $token = AnalyticsConfig::$matomoToken;
            if (!empty($token)) {
                $this->setParameter(MParameter::$AUTHTOKEN, $token);
                $this->setParameter(MParameter::$IP, HelperFunctions::getIpAddress());
            }
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
            $this->setParameter(MParameter::$USERID, $userId);
        } catch (JsonException $ignored) {
        }
    }

    /**
     * Static, because there is only one global page view id.
     *
     * @return string|null Six character unique ID, which is different for each page view. Gets generated on a MPageViewRequest
     */
    public static function getPageViewID(): ?string
    {
        return self::$pageViewID;
    }

    /**
     * Generates a six character page view ID
     */
    public static function generatePageViewID(): void
    {
        self::$pageViewID = substr(md5(uniqid(mt_rand(), true)), 0, 6);
    }

    /**
     * Sets the title of a page
     *
     * @param string $title The title of the current request
     * @param String[] $parents List of names of the parents of the current page
     */
    public function setPageTitle(string $title, array $parents = array()): void
    {
        $parents[] = $title;
        try {
            $this->setParameter(MParameter::$ACTION, implode("/", $parents));
        } catch (JsonException $e) {
        }
    }

    /**
     * @inheritDoc
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function send(): bool
    {
        if (empty(AnalyticsConfig::$matomoID) || empty(AnalyticsConfig::$matomoEndpoint)) {
            return false;
        }
        if (!empty($this->customVariables)) {
            try {
                $this->setParameter(MParameter::$CUSTOMVARIABLES, $this->customVariables);
            } catch (JsonException $ignored) {
            }
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

        $url = AnalyticsConfig::$matomoEndpoint;
        if (!HelperFunctions::endsWith($url, "/")) {
            $url .= "/";
        }
        $url .= "matomo.php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        $result = curl_exec($ch);
        $errors = curl_error($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $success = $this->requestSuccessful($errors, $response);
        if (!$success) {
            $debug = $this->isDebug();
            $query = $url . "?" . $content;
            if (function_exists('\Sentry\configureScope')) {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($debug, $result, $errors, $response, $parameters, $query): void {
                    $scope->setLevel(\Sentry\Severity::warning());
                    $scope->setExtra('Debug', $debug);
                    $scope->setExtra('Parameters', $parameters);
                    $scope->setExtra('Result', $result);
                    $scope->setExtra('Errors', $errors);
                    $scope->setExtra('Response Code', $response);
                    $scope->setExtra('Query', $query);
                    \Sentry\captureMessage("Error sending Matomo Analytics request.");
                });
                return false;
            }
            throw new RuntimeException("Error sending Matomo Analytics request.", $response);
        }
        return true;
    }

    /**
     * Evaluates the results by the curl request to determine, if it was successful.
     *
     * @param string $errors Errors returned by the request
     * @param mixed $responseCode The HTTP response code
     * @return bool True, if the request has been evaluated as successful
     */
    private function requestSuccessful(string $errors, $responseCode): bool
    {
        if (is_numeric($responseCode) && $responseCode !== 204) {
            return false;
        }
        if (!empty($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Sets a custom variable for a visit scope.
     *
     * @param string $key The key of the variable
     * @param array|string|integer|float|bool|null $value The value of the variable
     * @throws JsonException
     */
    public function addCustomVariable(string $key, $value): void
    {
        if (!empty($key) && !is_null($value) && (!is_array($value) || !empty($value))) {
            if (is_bool($value)) {
                $value = $value ? "1" : "0";
            } else if (is_array($value)) {
                $value = json_encode($value, JSON_THROW_ON_ERROR);
            } else {
                $value = (string)$value;
            }
            $this->customVariables[] = [$key, $value];
        }
    }

    /**
     * @inheritDoc
     */
    public function updateGenerationTime(): void
    {
        if (isset($GLOBALS["start_time"])) {
            try {
                $this->setParameter(MParameter::$GENERATIONTIME, round((microtime(true) - $GLOBALS["start_time"]) * 1000));
            } catch (JsonException $ignored) {
            }
        }
    }
}