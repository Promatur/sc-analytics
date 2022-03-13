<?php


namespace ScAnalytics\GoogleAnalytics\Requests;


use JsonException;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Class GAScreenViewRequest.
 * Screens in Google Analytics represent content users are viewing within an app. The equivalent concept for a website is pages. Measuring screen views allows you to see which content is being viewed most by your users, and how are they are navigating between different pieces of content.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/screens
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#apptracking
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cd
 */
class GAScreenViewRequest extends GARequest
{

    /**
     * GAScreenViewRequest constructor.
     * @param string $screenName The name of the screen
     * @param string|null $appId The ID of the application
     * @param string|null $appInstallerId The ID of the application installer
     */
    public function __construct(string $screenName, ?string $appId = null, ?string $appInstallerId = null)
    {
        parent::__construct();
        $this->setType("screenview");
        try {
            $this->setParameter(GAParameter::$SCREENNAME, $screenName);
            $this->setParameter(GAParameter::$APPID, $appId);
            $this->setParameter(GAParameter::$APPINSTALLERID, $appInstallerId);
        } catch (JsonException $ignored) {
        }
    }

}