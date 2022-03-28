<?php

namespace ScAnalytics\GoogleAnalytics4;

use JsonException;
use JsonSerializable;
use ScAnalytics\Analytics;
use ScAnalytics\Core\HelperFunctions;

/**
 * Class GA4Event. Up to 25 events can be sent per request.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events Event Reference
 * @link https://support.google.com/analytics/answer/9234069 Default events
 */
class GA4Event implements JsonSerializable
{

    /**
     * @var string Required. The name for the event.
     * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events See the events reference for all options.
     */
    private $name;

    /**
     * @var array<string, string> Optional. The parameters for the event.
     * @link https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events See events for the suggested parameters for each event.
     */
    private $parameters;

    /**
     * @param string $name Required. The name for the event.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->parameters = [];
        try {
            $this->setParameter(new GA4EventParameter("language"), Analytics::getScope()->getLanguage());
        } catch (JsonException $ignored) {
        }
    }

    /**
     * Sets a parameter of the request.
     * Passing a null value or an empty array will remove the parameter from the request.
     *
     * @param GA4EventParameter $key Key of the parameter
     * @param string|int|bool|float|array|null $value The value of the parameter. Set to <code>null</code> to remove it
     * @throws JsonException Thrown when an array cannot be encoded in JSON
     * @see HelperFunctions::toStringValue() Supported data types
     */
    public function setParameter(GA4EventParameter $key, $value): void
    {
        $val = HelperFunctions::toStringValue($value);
        if (is_null($val)) {
            unset($this->parameters[$key->getName()]);
        } else {
            $this->parameters[$key->getName()] = $val;
        }
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "name" => $this->name,
            "parameters" => $this->parameters
        ];
    }
}