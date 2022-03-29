<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4SearchEvent.
 * Use this event to contextualize search operations. This event can help you identify the most popular content in your app.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#search Documentation
 */
class GA4SearchEvent extends GA4Event
{

    /**
     * @param string $searchTerm The term that was searched for.
     */
    public function __construct(string $searchTerm)
    {
        parent::__construct('search');

        try {
            $this->setParameter(new GA4EventParameter("search_term"), $searchTerm);
        } catch (JsonException $ignored) {
        }
    }

}