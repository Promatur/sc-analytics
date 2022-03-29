<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4JoinGroupEvent.
 * Log this event when a user joins a group such as a guild, team, or family. Use this event to analyze how popular certain groups or social features are.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#join_group Documentation
 */
class GA4JoinGroupEvent extends GA4Event
{

    /**
     * @param string|null $groupId The ID of the group.
     */
    public function __construct(?string $groupId = null)
    {
        parent::__construct('join_group');

        try {
            $this->setParameter(new GA4EventParameter("group_id"), $groupId);
        } catch (JsonException $ignored) {
        }
    }

}