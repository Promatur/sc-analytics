<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4AdClickEvent.
 * When a user clicks an ad.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://support.google.com/analytics/answer/9234069?hl=en Documentation
 */
class GA4AdClickEvent extends GA4Event
{

    /**
     * @param string|null $adEventId The ID of the group.
     */
    public function __construct(?string $adEventId = null)
    {
        parent::__construct('ad_click');

        try {
            $this->setParameter(new GA4EventParameter("ad_event_id"), $adEventId);
        } catch (JsonException $ignored) {
        }
    }

}