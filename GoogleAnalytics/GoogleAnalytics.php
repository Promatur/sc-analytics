<?php

namespace ScAnalytics\GoogleAnalytics;

use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\ECommerce\Transaction;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCartAddRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCartRemoveRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCheckoutStepRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceProductClickRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceProductPageRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommercePurchaseRequest;
use ScAnalytics\GoogleAnalytics\Requests\GADownloadRequest;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;
use ScAnalytics\GoogleAnalytics\Requests\GAExceptionRequest;
use ScAnalytics\GoogleAnalytics\Requests\GALogoutRequest;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;
use ScAnalytics\GoogleAnalytics\Requests\GARequest;
use ScAnalytics\GoogleAnalytics\Requests\GASearchRequest;
use ScAnalytics\GoogleAnalytics\Requests\GASocialRequest;
use ScAnalytics\GoogleAnalytics\Requests\GATimingRequest;

/**
 * Class GoogleAnalytics. Responsible for managing Google Analytics.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://analytics.google.com/ Google Analytics website
 */
class GoogleAnalytics implements AnalyticsHandler
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "Google Analytics";
    }

    /**
     * @inheritDoc
     * @throws \JsonException
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
    {
        if (!$this->isAvailable()) {
            return "";
        }
        if (is_null($pageViewRequest)) {
            if (isset($GLOBALS['sc_pageView']) && $GLOBALS['sc_pageView'] instanceof GAPageViewRequest) {
                /** @noinspection CallableParameterUseCaseInTypeContextInspection */
                $pageViewRequest = $GLOBALS['sc_pageView'];
                if (is_null($pageViewRequest->getParameter(GAParameter::$DOCUMENTTITLE))) {
                    $pageViewRequest->setParameter(GAParameter::$DOCUMENTTITLE, $pageData->getPageTitle());
                }
            } else {
                $pageViewRequest = new GAPageViewRequest($pageData);
            }
        }
        $pageViewRequest->send();
        $assets = HelperFunctions::getAssetsDir();
        $result = '<script async src="https://www.googletagmanager.com/gtag/js?id=' . AnalyticsConfig::$googleAnalyticsIDs[0] . '"></script>';
        if (file_exists($assets . '/ga.min.js')) {
            $cacheBuster = filemtime($assets . '/ga.min.js');
            $result .= '<script src="' . AnalyticsConfig::$relativeAssetsPrefix . AnalyticsConfig::$assets . '/promatur/sc-analytics/ga.min.js?cb=' . $cacheBuster . '" id="_ga" data-keys="' . implode(";", AnalyticsConfig::$googleAnalyticsIDs) . '" data-consent="' . (Analytics::getScope()->hasAnalyticsConsent() ? 'true' : 'false') . '" data-clientid="' . self::getClientID() . '" defer></script>';
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(): bool
    {
        return !empty(AnalyticsConfig::$googleAnalyticsIDs);
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

    // - Requests

    /**
     * @inheritDoc
     */
    public function event(bool $interactive, string $category, string $action, ?string $label = null, ?int $value = null): ARequest
    {
        return new GAEventRequest($interactive, $category, $action, $label, $value);
    }

    /**
     * @inheritDoc
     */
    public function exception(?string $description = null, bool $fatal = false): ARequest
    {
        return new GAExceptionRequest($description, $fatal);
    }

    /**
     * @inheritDoc
     */
    public function pageView(?PageData $pageData): ARequest
    {
        return new GAPageViewRequest($pageData);
    }

    /**
     * @inheritDoc
     */
    public function social(string $network, string $action, string $target): ARequest
    {
        return new GASocialRequest($network, $action, $target);
    }

    /**
     * @inheritDoc
     */
    public function timing(string $group, string $name, int $milliseconds, ?string $label = null): ARequest
    {
        return new GATimingRequest($group, $name, $milliseconds, $label);
    }

    /**
     * @inheritDoc
     */
    public function search(?PageData $pageData, string $keyword, int $results, string $category = "all"): ARequest
    {
        return new GASearchRequest($pageData, $keyword, $results, $category);
    }

    /**
     * @inheritDoc
     */
    public function logout(): ARequest
    {
        return new GALogoutRequest();
    }

    /**
     * @inheritDoc
     */
    public function download(string $fileName, ?int $size = null): ARequest
    {
        return new GADownloadRequest($fileName, $size);
    }

    // - ECommerce

    /**
     * @inheritDoc
     */
    public function addCart(array $products): ARequest
    {
        return new GAECommerceCartAddRequest($products);
    }

    /**
     * @inheritDoc
     */
    public function removeCart(array $products): ARequest
    {
        return new GAECommerceCartRemoveRequest($products);
    }

    /**
     * @inheritDoc
     */
    public function purchase(Transaction $transaction): ARequest
    {
        return new GAECommercePurchaseRequest($transaction);
    }

    /**
     * @inheritDoc
     */
    public function checkoutStep(?PageData $pageData, array $products, int $step, ?string $option = null): ARequest
    {
        return new GAECommerceCheckoutStepRequest($pageData, $products, $step, $option);
    }

    /**
     * @inheritDoc
     */
    public function productClick(string $listName, Product $product, int $productPosition = 1): ARequest
    {
        return new GAECommerceProductClickRequest($listName, $product, $productPosition);
    }

    /**
     * @inheritDoc
     */
    public function productPage(Product $product, ?PageData $pageData = null): ARequest
    {
        return new GAECommerceProductPageRequest($product, $pageData);
    }
}