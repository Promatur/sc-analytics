<?php


namespace ScAnalytics\Core;


/**
 * Interface AnalyticsHandler. This interface creates a simple interface for all integrated analytics handlers. This interface maps different functions to the specific parameters of the analytics handlers.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
interface AnalyticsHandler
{

    /**
     * @return string The name of the Analytics Handler
     */
    public function getName(): string;

    /**
     * @return bool A boolean, if the Analytics Handler is available and configured
     */
    public function isAvailable(): bool;

    /**
     * Loads the Analytics API in a privacy-friendly way. It also sends a PageView request using the PHP API to get a reliable amount of page views. The page view using the JavaScript API is disabled. The initial <code>pageViewRequest</code> can also be set in <code>$GLOBALS["pageView"]</code> <b>before</b> calling this method. This can be useful, if you want to send a custom page view request with additional data.
     *
     * @param PageData $pageData The data of the current page
     * @param ARequest|null $pageViewRequest An initial page view request. Set to <code>null</code> to use the default one
     * @return string HTML code
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string;
}