<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4LoginEvent.
 * Send this event to signify that a user has logged in.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#login Documentation
 */
class GA4LoginEvent extends GA4Event
{

    /**
     * @param string|null $method The ID of the group.
     */
    public function __construct(?string $method = null)
    {
        parent::__construct('login');

        try {
            $this->setParameter(new GA4EventParameter("method"), $method);
        } catch (JsonException $ignored) {
        }
    }

}