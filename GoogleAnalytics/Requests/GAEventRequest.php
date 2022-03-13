<?php


namespace ScAnalytics\GoogleAnalytics\Requests;

use JsonException;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Class GAEventRequest. Events are user interactions with content that can be measured independently of a web page or a screen load.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/events
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#events
 */
class GAEventRequest extends GARequest
{

    /**
     * GAEventRequest constructor.
     * @param bool $interactive A boolean, if the event is a result of user interaction
     * @param string $category Typically the object that was interacted with
     * @param string $action The type of interaction
     * @param string|null $label Useful for categorizing events
     * @param int|null $value A numeric value associated with the event
     */
    public function __construct(bool $interactive, string $category, string $action, ?string $label = null, ?int $value = null)
    {
        parent::__construct();
        $this->setType('event');
        try {
            $this->setParameter(GAParameter::$NONINTERACTION, !$interactive);
            $this->setParameter(GAParameter::$EVENTCATEGORY, $category);
            $this->setParameter(GAParameter::$EVENTACTION, $action);
            $this->setParameter(GAParameter::$EVENTLABEL, $label);
            $this->setParameter(GAParameter::$EVENTVALUE, $value);
        } catch (JsonException $ignored) {
        }
    }

}