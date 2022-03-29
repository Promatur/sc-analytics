<?php

namespace ScAnalytics\GoogleAnalytics4\Events;

use JsonException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Class GA4SelectContentEvent.
 * This event signifies that a user has selected some content of a certain type. This event can help you identify popular content and categories of content in your app.
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#select_content Documentation
 */
class GA4SelectContentEvent extends GA4Event
{

    /**
     * @param string|null $contentType The type of selected content.
     * @param string|null $itemId An identifier for the item that was selected.
     */
    public function __construct(?string $contentType = null, ?string $itemId = null)
    {
        parent::__construct('select_content');

        try {
            $this->setParameter(new GA4EventParameter("content_type"), $contentType);
            $this->setParameter(new GA4EventParameter("item_id"), $itemId);
        } catch (JsonException $ignored) {
        }
    }

}