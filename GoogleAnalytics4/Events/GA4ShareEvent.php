<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4ShareEvent.
 * Use this event when a user has shared content.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#share Documentation
 */
class GA4ShareEvent extends GA4Event
{

    /**
     * @param string|null $method The method in which the content is shared.
     * @param string|null $contentType The type of shared content.
     * @param string|null $itemId The ID of the shared content.
     */
    public function __construct(?string $method = null, ?string $contentType = null, ?string $itemId = null)
    {
        parent::__construct('share');

        try {
            $this->setParameter(new GA4EventParameter("method"), $method);
            $this->setParameter(new GA4EventParameter("content_type"), $contentType);
            $this->setParameter(new GA4EventParameter("item_id"), $itemId);
        } catch (JsonException $ignored) {
        }
    }

}