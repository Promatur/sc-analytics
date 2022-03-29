<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4ViewSearchResultsEvent.
 * Log this event when the user has been presented with the results of a search.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#view_search_results Documentation
 */
class GA4ViewSearchResultsEvent extends GA4Event
{

    /**
     * @param string|null $searchTerm The term used for the search.
     */
    public function __construct(?string $searchTerm = null)
    {
        parent::__construct('view_search_results');

        try {
            $this->setParameter(new GA4EventParameter("search_term"), $searchTerm);
        } catch (JsonException $ignored) {
        }
    }

}