<?php


namespace ScAnalytics\Matomo\Requests;


use JsonException;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MEventRequest. Events are user interactions with content that can be measured independently of a web page or a screen load.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MEventRequest extends MRequest
{

    /**
     * MEventRequest constructor.
     *
     * @param string $category Typically the object that was interacted with
     * @param string $action The type of interaction
     * @param string|null $label Useful for categorizing events
     * @param int|null $value A numeric value associated with the event
     */
    public function __construct(string $category, string $action, ?string $label = null, ?int $value = null)
    {
        parent::__construct();
        try {
            $this->setParameter(MParameter::$ACTION, $category . "/" . $action);
            $this->setParameter(MParameter::$EVENTCATEGORY, $category);
            $this->setParameter(MParameter::$EVENTACTION, $action);
            $this->setParameter(MParameter::$EVENTLABEL, $label);
            $this->setParameter(MParameter::$EVENTVALUE, $value);
            $this->setParameter(MParameter::$CUSTOMACTION, true);
        } catch (JsonException $ignored) {
        }
    }

}