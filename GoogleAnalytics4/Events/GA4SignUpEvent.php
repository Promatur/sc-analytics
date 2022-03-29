<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4SignUpEvent.
 * This event indicates that a user has signed up for an account. Use this event to understand the different behaviors of logged in and logged out users.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#sign_up Documentation
 */
class GA4SignUpEvent extends GA4Event
{

    /**
     * @param string|null $method The method used for sign up.
     */
    public function __construct(?string $method = null)
    {
        parent::__construct('sign_up');

        try {
            $this->setParameter(new GA4EventParameter("method"), $method);
        } catch (JsonException $ignored) {
        }
    }

}