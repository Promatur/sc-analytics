<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use ScAnalytics\GoogleAnalytics4\GA4Event;

/**
 * Class GA4TutorialCompleteEvent.
 * This event signifies the user's completion of your on-boarding process. Use this in a funnel with <code>GA4TutorialBeginEvent</code> to understand how many users complete the tutorial.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#tutorial_complete Documentation
 * @see GA4TutorialBeginEvent
 */
class GA4TutorialCompleteEvent extends GA4Event
{

    /**
     */
    public function __construct()
    {
        parent::__construct('tutorial_complete');
    }

}