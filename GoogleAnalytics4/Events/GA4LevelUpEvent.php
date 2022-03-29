<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4LevelUpEvent.
 * This event signifies that a player has leveled up. Use it to gauge the level distribution of your userbase and identify levels that are difficult to complete.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#level_up Documentation
 */
class GA4LevelUpEvent extends GA4Event
{

    /**
     * @param int|null $level The level of the character.
     * @param string|null $character The character that leveled up.
     */
    public function __construct(?int $level = null, ?string $character = null)
    {
        parent::__construct('level_up');

        try {
            $this->setParameter(new GA4EventParameter("level"), $level);
            $this->setParameter(new GA4EventParameter("character"), $character);
        } catch (JsonException $ignored) {
        }
    }

}