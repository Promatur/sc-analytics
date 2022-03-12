<?php

namespace ScAnalytics\GoogleAnalytics;

use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;

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
     */
    public function isAvailable(): bool
    {
        return !empty(AnalyticsConfig::$googleAnalyticsIDs);
    }

    /**
     * @inheritDoc
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
    {
        return "";// TODO: Implement loadJS() method.
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
}