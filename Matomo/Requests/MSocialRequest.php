<?php


namespace ScAnalytics\Matomo\Requests;


/**
 * Class MSocialRequest. You can use social interaction analytics to measure the number of times users click on social buttons embedded in webpages. For example, you might measure a Facebook "Like" or a Twitter "Tweet".
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MSocialRequest extends MEventRequest
{

    /**
     * ASocialRequest constructor.
     * @param string $network The network on which the action occurs (e.g. Facebook, Twitter)
     * @param string $action The type of action that happens (e.g. Like, Send, Tweet)
     * @param string $target Specifies the target of a social interaction. This value is typically a URL but can be any text (e.g. https://promatur.com)
     */
    public function __construct(string $network, string $action, string $target)
    {
        parent::__construct("Social Media", "$network ($action)", $target);
    }

}