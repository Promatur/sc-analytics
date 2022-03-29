<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use ScAnalytics\GoogleAnalytics4\GA4Event;

/**
 * Class GA4TutorialBeginEvent.
 * This event signifies the start of the on-boarding process. Use this in a funnel with <code>GA4TutorialCompleteEvent</code> to understand how many users complete the tutorial.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#tutorial_begin Documentation
 * @see GA4TutorialCompleteEvent
 */
class GA4TutorialBeginEvent extends GA4Event
{

    /**
     */
    public function __construct()
    {
        parent::__construct('tutorial_begin');
    }

}