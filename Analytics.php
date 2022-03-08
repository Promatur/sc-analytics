<?php

namespace ScAnalytics;

use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GoogleAnalytics;
use ScAnalytics\Matomo\Matomo;
use ScAnalytics\NoAnalytics\NoAnalytics;
use ScAnalytics\Tests\AnalyticsTest;

/**
 * Class Analytics. Manages all existing analytics integrations and helps to select a suitable one.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see AnalyticsTest phpunit test
 */
class Analytics
{
    /**
     * @var AnalyticsHandler|null Current active analytics handler.
     */
    private static $analytics;

    /**
     * @var AnalyticsHandler[] List of available analytics handlers.
     */
    private static $analyticsList = array();

    /**
     * @var Scope User-specific settings to the analytics APIs, which are used to enrich requests
     */
    private static $scope;

    /**
     * Creates a list of possible analytics handlers and activates the preferred one.
     * @param Scope|null $scope An optional Scope with user-specific settings to the analytics APIs, which are used to enrich requests
     * @see Analytics::checkStatus()
     */
    public static function init(?Scope $scope = null): void
    {
        self::$scope = $scope ?? new Scope();
        self::$analyticsList = array(new Matomo(), new GoogleAnalytics());
        self::checkStatus();
    }

    /**
     * Activates the best analytics system by iterating over the list of possible analytics handlers and assigning the first one available.
     * @see Analytics::$analytics List of possible handlers
     */
    public static function auto(): void
    {
        foreach (self::$analyticsList as $analytics) {
            if ($analytics->isAvailable()) {
                self::$analytics = $analytics;
                break;
            }
        }
    }

    /**
     * It will automatically assign the correct analytics handler or use the configured one.
     *
     * @see Analytics::init() Call init() before this method
     */
    public static function checkStatus(): void
    {
        if (is_null(self::$analytics) || self::$analytics instanceof NoAnalytics) {
            if (strcasecmp(AnalyticsConfig::$preferred, "auto") === 0) {
                self::auto();
            } else {
                foreach (self::$analyticsList as $handler) {
                    if ($handler->isAvailable() && strcasecmp($handler->getName(), AnalyticsConfig::$preferred) === 0) {
                        self::$analytics = $handler;
                        break;
                    }
                }
            }
        }
        if (is_null(self::$analytics)) {
            self::$analytics = new NoAnalytics();
        }
    }

    /**
     * Will automatically assign the correct Analytics Handler, if none is set.
     *
     * @return AnalyticsHandler Current active analytics handler.
     * @see Analytics::init() Initialize before calling this function
     * @see Analytics::checkStatus() Called before returning the active analytics handler
     */
    public static function get(): AnalyticsHandler
    {
        self::checkStatus();
        if (is_null(self::$analytics)) {
            self::$analytics = new NoAnalytics();
        }
        return self::$analytics;
    }

    /**
     * @return Scope User-specific settings to the analytics APIs, which are used to enrich requests
     */
    public static function getScope(): Scope
    {
        return self::$scope;
    }

}