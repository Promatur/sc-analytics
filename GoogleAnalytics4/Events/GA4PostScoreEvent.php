<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4PostScoreEvent.
 * Send this event when the user posts a score. Use this event to understand how users are performing in your game and correlate high scores with audiences or behaviors.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#post_score Documentation
 */
class GA4PostScoreEvent extends GA4Event
{

    /**
     * @param int $score The score to post.
     * @param int|null $level The level for the score.
     * @param string|null $character The character that achieved the score.
     */
    public function __construct(int $score, ?int $level = null, ?string $character = null)
    {
        parent::__construct('post_score');

        try {
            $this->setParameter(new GA4EventParameter("score"), $score);
            $this->setParameter(new GA4EventParameter("level"), $level);
            $this->setParameter(new GA4EventParameter("character"), $character);
        } catch (JsonException $ignored) {
        }
    }

}