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
     * Possible options: 'auto', 'matomo', 'google analytics'.
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
     * Support multiple Google Analytics IDs. The first id will be used to load the gtag.js script.
     *
     * @var string[] Google Analytics IDs
     */
    public static $googleAnalyticsIDs = [];

    /**
     * Has to be same as <code>extra.assets-dir</code> in the <i>composer.json</i>.
     *
     * @var string Location of the JavaScript assets
     */
    public static $assets = "libraries";

}