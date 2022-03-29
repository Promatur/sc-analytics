<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4SessionStartEvent.
 * Sent at the start of a session. Currently, sending session starts using measurement api is not supported.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://support.google.com/analytics/answer/9234069 Documentation
 */
class GA4SessionStartEvent extends GA4Event
{

    /**
     * @param string $pageLocation Page URL
     * @param string|null $pageTitle Page title
     * @param string|null $pageReferrer Previous page URL
     */
    public function __construct(string $pageLocation, ?string $pageTitle = null, ?string $pageReferrer = null)
    {
        parent::__construct('session_start');

        try {
            $this->setParameter(new GA4EventParameter("page_location"), $pageLocation);
            $this->setParameter(new GA4EventParameter("page_title"), $pageTitle);
            $this->setParameter(new GA4EventParameter("page_referrer"), $pageReferrer);
        } catch (JsonException $ignored) {
        }
    }

}