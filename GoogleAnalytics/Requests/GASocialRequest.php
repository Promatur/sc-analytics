<?php


namespace ScAnalytics\GoogleAnalytics\Requests;


use JsonException;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Class GASocialRequest. You can use social interaction analytics to measure the number of times users click on social buttons embedded in webpages. For example, you might measure a Facebook "Like" or a Twitter "Tweet".
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/analyticsjs/social-interactions
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#social
 */
class GASocialRequest extends GARequest
{

    /**
     * GASocialRequest constructor.
     * @param string $network The network on which the action occurs (e.g. Facebook, Twitter)
     * @param string $action The type of action that happens (e.g. Like, Send, Tweet)
     * @param string $target Specifies the target of a social interaction. This value is typically a URL but can be any text (e.g. https://promatur.com)
     */
    public function __construct(string $network, string $action, string $target)
    {
        parent::__construct();
        $this->setType("social");
        try {
            $this->setParameter(GAParameter::$SOCIALNETWORK, $network);
            $this->setParameter(GAParameter::$SOCIALACTION, $action);
            $this->setParameter(GAParameter::$SOCIALTARGET, $target);
        } catch (JsonException $e) {
        }
    }

}