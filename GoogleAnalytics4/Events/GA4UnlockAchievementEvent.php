<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4UnlockAchievementEvent.
 * Log this event when the user has unlocked an achievement. This event can help you understand how users are experiencing your game.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#unlock_achievement Documentation
 */
class GA4UnlockAchievementEvent extends GA4Event
{

    /**
     * @param string $achievementId The id of the achievement that was unlocked.
     */
    public function __construct(string $achievementId)
    {
        parent::__construct('unlock_achievement');

        try {
            $this->setParameter(new GA4EventParameter("achievement_id"), $achievementId);
        } catch (JsonException $ignored) {
        }
    }

}