<?php

namespace ScAnalytics\GoogleAnalytics4;

use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\ECommerce\Transaction;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\GoogleAnalytics4\Requests\GA4PageViewRequest;
use ScAnalytics\NoAnalytics\NoRequest;

/**
 * Class GoogleAnalytics4. Responsible for managing Google Analytics 4.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://analytics.google.com/ Google Analytics website
 */
class GoogleAnalytics4 implements AnalyticsHandler
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "Google Analytics 4";
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(): bool
    {
        return !empty(AnalyticsConfig::$googleAnalytics4);
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
                $pageViewRequest = new GA4PageViewRequest($pageData);
            }
        }
        $pageViewRequest->send();
        $assets = HelperFunctions::getAssetsDir();
        $result = '<script async src="https://www.googletagmanager.com/gtag/js?id=' . array_key_first(AnalyticsConfig::$googleAnalytics4) . '"></script>';
        if (file_exists($assets . '/ga4.min.js')) {
            $cacheBuster = filemtime($assets . '/ga4.min.js');
            $session = self::getSessionData();
            $result .= '<script src="' . AnalyticsConfig::$relativeAssetsPrefix . AnalyticsConfig::$assets . '/promatur/sc-analytics/ga4.min.js?cb=' . $cacheBuster . '" id="_ga4" data-keys="' . implode(";", array_keys(AnalyticsConfig::$googleAnalytics4)) . '" data-consent="' . (Analytics::getScope()->hasAnalyticsConsent() ? 'true' : 'false') . '" data-clientid="' . self::getClientID() . '" data-sessionid="' . $session['id'] . '" defer></script>';
        }
        return $result;
    }

    /**
     * Checks different cookies for the GA client id or generates a new one, which is saved in <code>$_SESSION['ga_tempid']</code>.
     *
     * @return string Google Analytics client ID
     */
    public static function getClientID(): string
    {
        if (isset($_COOKIE['_ga'])) {
            return preg_replace('/GA\d\.\d+\./', '', $_COOKIE['_ga']);
        }
        if (isset($_COOKIE['_gid'])) {
            return $_COOKIE['_gid'];
        }
        if (!isset($_SESSION['ga_tempid'])) {
            $_SESSION['ga_tempid'] = HelperFunctions::generateUUID();
        }
        return $_SESSION['ga_tempid'];
    }

    /**
     * Reads session data from cookie or php session.
     * @return array<string, string|int> Session data with the keys 'id' and 'number'
     */
    public static function getSessionData(): array
    {
        $consent = Analytics::getScope()->hasAnalyticsConsent();
        if (isset($_SESSION['ga_session'])) {
            $cookie = $_SESSION['ga_session']['id'] . "." . $_SESSION['ga_session']['number'];
            if ($consent && $_COOKIE['_ga_session'] !== $cookie) {
                self::setSessionCookie($cookie);
            }
            return $_SESSION['ga_session'];
        }
        if (isset($_COOKIE['_ga_session']) && str_contains($_COOKIE['_ga_session'], '.')) {
            $split = explode('.', $_COOKIE['_ga_session']);
            $_SESSION['ga_session'] = ['id' => $split[1], 'number' => $split[0]];
            return $_SESSION['ga_session'];
        }
        $id = str_replace('-', '', HelperFunctions::generateUUID() ?? "ERROR");
        $_SESSION['ga_session'] = ["id" => $id, "number" => 1];
        if ($consent) {
            $cookie = $_SESSION['ga_session']['id'] . "." . $_SESSION['ga_session']['number'];
            self::setSessionCookie($cookie);
        }
        return $_SESSION['ga_session'];
    }

    /**
     * Sets the session information cookie '_ga_session' with a duration of 2 years.
     *
     * @param string $value The value of the cookie to set
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    private static function setSessionCookie(string $value): void
    {
        $cookieExpire = time() + 31536000; // 2 years
        if (!headers_sent()) {
            $header = 'Set-Cookie: _ga_session=' . rawurlencode($value)
                . '; expires=' . gmdate('D, d-M-Y H:i:s', $cookieExpire) . ' GMT'
                . '; path=/'
                . (!HelperFunctions::isHTTPS() ? '' : '; secure')
                . '; SameSite=' . rawurlencode("Lax");

            header($header, false);
        } else if (function_exists('\Sentry\configureScope')) {
            \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($value, $cookieExpire): void {
                $scope->setExtra('Cookie name', "_ga_session");
                $scope->setExtra('Cookie value', $value);
                $scope->setExtra('Cookie ttl', "2 years");
                $scope->setExtra('Cookie expire', $cookieExpire);
                \Sentry\captureMessage("Tried to set cookie with header, but headers are already sent.");
            });
        }
    }

    // - Requests

    /**
     * @inheritDoc
     */
    public function event(bool $interactive, string $category, string $action, ?string $label = null, ?int $value = null): ARequest
    {
        // TODO: Implement event() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function exception(?string $description = null, bool $fatal = false): ARequest
    {
        // TODO: Implement exception() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function pageView(?PageData $pageData): ARequest
    {
        return new GA4PageViewRequest($pageData);
    }

    /**
     * @inheritDoc
     */
    public function social(string $network, string $action, string $target): ARequest
    {
        // TODO: Implement social() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function timing(string $group, string $name, int $milliseconds, ?string $label = null): ARequest
    {
        // TODO: Implement timing() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function search(?PageData $pageData, string $keyword, int $results, string $category = "all"): ARequest
    {
        // TODO: Implement search() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function logout(): ARequest
    {
        // TODO: Implement logout() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function download(string $fileName, ?int $size = null): ARequest
    {
        // TODO: Implement download() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function addCart(array $products): ARequest
    {
        // TODO: Implement addCart() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function removeCart(array $products): ARequest
    {
        // TODO: Implement removeCart() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function purchase(Transaction $transaction): ARequest
    {
        // TODO: Implement purchase() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function checkoutStep(?PageData $pageData, array $products, int $step, ?string $option = null): ARequest
    {
        // TODO: Implement checkoutStep() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function productClick(string $listName, Product $product, int $productPosition = 1): ARequest
    {
        // TODO: Implement productClick() method.
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function productPage(Product $product, ?PageData $pageData = null): ARequest
    {
        // TODO: Implement productPage() method.
        return new NoRequest();
    }
}