<?php

namespace ScAnalytics\Core;

/**
 * Class AnalyticsConfig. Configuration variables for using the analytics system.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class AnalyticsConfig
{

    /**
     * Enable debug to send all requests to the debug endpoints of the analytics endpoints.
     *
     * @var bool True or false
     */
    public static $debug = false;

    /**
     * Optional. Specify the version of your own app here.
     *
     * @var string|null A version string
     */
    public static $version;

    /**
     * Has to be same as <code>extra.assets-dir</code> in the <i>composer.json</i>.
     *
     * @var string Location of the JavaScript assets
     */
    public static $assets = "assets";

    /**
     * The default currency for all ECommerce events.
     *
     * @var string EUR, USD, GBP, ...
     */
    public static $currency = "USD";

    /**
     * Your preferred analytics handler. Possible options: 'auto', 'matomo', 'google analytics'.
     *
     * @var string Preferred analytics handler
     */
    public static $preferred = "auto";

    /**
     * @var string Unique Matomo site ID of this website
     */
    public static $matomoID = "";

    /**
     * @var string URL to the matomo Endpoint without the matomo.php file
     */
    public static $matomoEndpoint = "";

    /**
     * Optional. Allows sending additional information like the IP address. Treat this token as confidential.
     *
     * @var string Matomo token to authenticate API requests
     * @link https://matomo.org/faq/general/faq_114/ Documentation
     */
    public static $matomoToken = "";

    /**
     *
     *
     * @var string[] Google Analytics IDs
     */
    public static $googleAnalyticsIDs = [];

}