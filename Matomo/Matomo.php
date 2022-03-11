<?php

namespace ScAnalytics\Matomo;

use JsonException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\Matomo\Requests\MPageViewRequest;

/**
 * Class Matomo. The matomo analytics handler handles the integration of the Matomo analytics platform.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://matomo.org Matomo website
 */
class Matomo implements AnalyticsHandler
{

    /**
     * @var string First party cookie path
     */
    private const COOKIE_PATH = '/';
    /**
     * @var int Visitor ID length
     */
    public const LENGTH_VISITOR_ID = 16;
    /**
     * @var string Prefix for cookies
     */
    private const FIRST_PARTY_COOKIES_PREFIX = '_pk_';

    /**
     * Matomo constructor.
     */
    public function __construct()
    {
        if ($this->isAvailable() && !headers_sent()) {
            try {
                self::setFirstPartyCookies();
            } catch (JsonException $e) {
                if (function_exists('\Sentry\captureException')) {
                    /** @noinspection PhpFullyQualifiedNameUsageInspection */
                    \Sentry\captureException($e);
                }
            }
        }
    }

    /**
     * Stores a variable in the matomo session storage.
     *
     * @param string $key Key of the value
     * @param mixed $value Value
     */
    public static function setVariable(string $key, $value): void
    {
        if (!isset($_SESSION['matomo'])) {
            $_SESSION['matomo'] = [];
        }
        $arr = $_SESSION['matomo'];
        $arr[$key] = $value;
        $_SESSION['matomo'] = $arr;
    }

    /**
     * Loads a variable from the matomo session storage.
     *
     * @param string $key Key of the variable
     * @return mixed|null Value of the variable
     */
    public static function getVariable(string $key)
    {
        return $_SESSION['matomo'][$key] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "Matomo";
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(): bool
    {
        return !empty(AnalyticsConfig::$matomoID) && !empty(AnalyticsConfig::$matomoEndpoint);
    }

    /**
     * @inheritDoc
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
    {
        if (!$this->isAvailable()) {
            return "";
        }
        if (is_null($pageViewRequest)) {
            if (isset($GLOBALS['sc_pageView']) && $GLOBALS['sc_pageView'] instanceof ARequest) {
                /** @noinspection CallableParameterUseCaseInTypeContextInspection */
                $pageViewRequest = $GLOBALS['sc_pageView'];
            } else {
                $pageViewRequest = new MPageViewRequest($pageData);
            }
        }
        /** @var MPageViewRequest $pageViewRequest */
        $pageViewRequest->send();
        $url = AnalyticsConfig::$matomoEndpoint;
        if (!HelperFunctions::endsWith($url, "/")) {
            $url .= "/";
        }
        $assets = HelperFunctions::getAssetsDir();
        if (file_exists($assets . '/matomo.min.js')) {
            return '<script src="' . AnalyticsConfig::$assets . '/promatur/sc-analytics/matomo.min.js" id="_matomo" data-pv="' . $pageViewRequest->getPageViewId() . '" data-url="' . $url . '" data-siteid="' . AnalyticsConfig::$matomoID . '" data-visitorid="' . self::getVisitorId() . '" defer></script>';
        }
        return "";
    }

    /**
     * Sets the first party cookies as would the matomo.js
     * All cookies are supported: 'id' and 'ses' and 'ref' and 'cvar' cookies.
     * @throws JsonException
     */
    public static function setFirstPartyCookies(): void
    {
        if (empty(self::getVariable("visitorId"))) {
            self::loadVisitorIdCookie();
        }
        if (!Analytics::getScope()->hasAnalyticsConsent()) {
            return;
        }

        // Set the 'ref' cookie
        $attributionInfo = self::getAttributionInfo();
        if (!empty($attributionInfo)) {
            self::setCookie('ref', $attributionInfo, 15768000); // 6 Months
        }

        // Set the 'ses' cookie
        self::setCookie('ses', '*', 1800); // 30 Minutes

        // Set the 'id' cookie
        $cookieValue = self::getVisitorId() . '.' . self::getVariable("createTs");
        self::setCookie('id', $cookieValue, 33955200); // 13 Months

        // Set the 'cvar' cookie
        self::setCookie('cvar', json_encode(self::getCustomVariables(), JSON_THROW_ON_ERROR), 1800); // 30 minutes
    }

    /**
     * If the user initiating the request has the Matomo first party cookie,
     * this function will try and return the ID parsed from this first party cookie (found in $_COOKIE).
     *
     * If you call this function from a server, where the call is triggered by a cron or script
     * not initiated by the actual visitor being tracked, then it will return
     * the random Visitor ID that was assigned to this visit object.
     *
     * This can be used if you wish to record more visits, actions or goals for this visitor ID later on.
     *
     * @return string|null 16 hex chars visitor ID string
     */
    public static function getVisitorId(): ?string
    {
        $visitorId = self::getVariable("visitorId");
        if (!empty($visitorId) && is_string($visitorId)) {
            return $visitorId;
        }
        if (self::loadVisitorIdCookie()) {
            $visitorId = self::getVariable("visitorId");
            if (!empty($visitorId) && is_string($visitorId)) {
                return $visitorId;
            }
        }
        $visitorId = substr(str_replace("-", "", Analytics::getScope()->getClientId() ?? ""), 0, self::LENGTH_VISITOR_ID);
        self::setVariable("visitorId", $visitorId);
        return $visitorId;
    }

    /**
     * Returns the currently assigned Attribution Information stored in a first party cookie.
     *
     * This function will only work if the user is initiating the current request, and his cookies
     * can be read by PHP from the $_COOKIE array.
     *
     * @return string|null JSON Encoded string containing the Referrer information for Goal conversion attribution.
     *                Will return false if the cookie could not be found
     * @throws JsonException
     * @see matomo.js getAttributionInfo()
     */
    public static function getAttributionInfo(): ?string
    {
        if (!empty(self::getVariable("attributionInfo"))) {
            return json_encode(self::getVariable("attributionInfo"), JSON_THROW_ON_ERROR);
        }

        return self::getCookieMatchingName('ref');
    }

    /**
     * Gets the custom variables from the cookie.
     *
     * @return mixed false, if cookie not found or the data as array
     * @throws JsonException
     */
    protected static function getCustomVariables()
    {
        $cookie = self::getCookieMatchingName('cvar');
        if (!$cookie) {
            return false;
        }

        return json_decode($cookie, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Sets a first party cookie to the client to improve dual JS-PHP tracking.
     * This replicates the matomo.js tracker algorithms for consistency and better accuracy.
     *
     * @param string $cookieName Name of the cookie
     * @param string $cookieValue Value of the cookie
     * @param int $cookieTTL Time to live for the cookie
     * @return void
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    protected static function setCookie(string $cookieName, string $cookieValue, int $cookieTTL): void
    {
        $cookieExpire = time() + $cookieTTL;
        if (!headers_sent()) {
            $header = 'Set-Cookie: ' . rawurlencode(self::getCookieName($cookieName)) . '=' . rawurlencode($cookieValue)
                . (empty($cookieExpire) ? '' : '; expires=' . gmdate('D, d-M-Y H:i:s', $cookieExpire) . ' GMT')
                . '; path=' . self::COOKIE_PATH
                . (!HelperFunctions::isHTTPS() ? '' : '; secure')
                . '; SameSite=' . rawurlencode("Lax");

            header($header, false);
        } else if (function_exists('\Sentry\configureScope')) {
            \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($cookieName, $cookieValue, $cookieTTL, $cookieExpire): void {
                $scope->setExtra('Cookie name', $cookieName);
                $scope->setExtra('Cookie value', $cookieValue);
                $scope->setExtra('Cookie ttl', $cookieTTL);
                $scope->setExtra('Cookie expire', $cookieExpire);
                \Sentry\captureMessage("Tried to set cookie with header, but headers are aleady sent.");
            });
        }
    }

    /**
     * Loads values from the VisitorId cookie.
     *
     * @return bool True if cookie exists and is valid, False otherwise
     */
    protected static function loadVisitorIdCookie(): bool
    {
        $idCookie = self::getCookieMatchingName('id');
        if (empty($idCookie)) {
            return false;
        }
        $parts = explode('.', $idCookie);
        if (strlen($parts[0]) !== self::LENGTH_VISITOR_ID) {
            return false;
        }
        self::setVariable("visitorId", $parts[0]);
        self::setVariable("createTs", $parts[1]);
        return true;
    }

    /**
     * Returns a first party cookie which name contains $name.
     *
     * @param string $name
     * @return string|null String value of cookie, or null if not found
     */
    protected static function getCookieMatchingName(string $name): ?string
    {
        if (!is_array($_COOKIE)) {
            return null;
        }
        $name = self::getCookieName($name);

        // Matomo cookie names use dots separators in matomo.js,
        // but PHP Replaces . with _ http://www.php.net/manual/en/language.variables.predefined.php#72571
        $name = str_replace('.', '_', $name);
        foreach ($_COOKIE as $cookieName => $cookieValue) {
            if (strpos($cookieName, $name) !== false) {
                return $cookieValue;
            }
        }
        return null;
    }

    /**
     * Get cookie name with prefix and domain hash.
     * @param string $cookieName Cookie name
     * @return string Formatted cookie name
     */
    protected static function getCookieName(string $cookieName): string
    {
        // NOTE: If the cookie name is changed, we must also update the method in matomo.js with the same name.
        $hash = substr(sha1(self::getCurrentHost() . self::COOKIE_PATH), 0, 4);
        return self::FIRST_PARTY_COOKIES_PREFIX . $cookieName . '.' . AnalyticsConfig::$matomoID . '.' . $hash;
    }

    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "http://example.org"
     *
     * @return string
     */
    protected static function getCurrentHost(): string
    {
        return $_SERVER['HTTP_HOST'] ?? 'unknown';
    }
}