<?php


namespace ScAnalytics\Core;


use JsonException;

/**
 * Class ARequest. An abstract analytics request, which is meant to be extended by different analytics providers.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
abstract class ARequest
{

    /**
     * @var array<string, string> A key-value-map of all parameters
     */
    private $parameters = [];

    /**
     * @var bool A boolean, if the request should be sent to the debug endpoint
     */
    private $debug;

    /**
     * Initializes the ARequest.
     */
    public function __construct()
    {
        $this->debug = AnalyticsConfig::$debug;
    }

    /**
     * @return bool A boolean, if the request should be sent to the debug endpoint
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug A boolean, if the request should be sent to the debug endpoint
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * Sets a custom user for the request.
     *
     * @param int|null $userId Unique ID of the user
     * @see ARequest::setUserIdentifier()
     */
    public function setUser(?int $userId): void
    {
        $this->setUserIdentifier(is_null($userId) ? null : (string)$userId);
    }

    /**
     * Sets a custom user for the request.
     *
     * @param string|null $userId Unique ID of the user
     */
    abstract public function setUserIdentifier(?string $userId): void;

    /**
     * Updates the generation time to the current timestamp. For this to work, <code>$GLOBALS["start_time"] = microtime(true);</code> has to be set at the beginning of the execution. Has to be called before <code>send()</code>.
     *
     * @see GAParameter::$LOADTIME Google Analytics Load Time
     * @see MParameter::$GENERATIONTIME Matomo Generation Time
     */
    abstract public function updateGenerationTime(): void;

    /**
     * Sets a parameter of the request.
     * Passing a null value or an empty array will remove the parameter from the request.
     *
     * @param AParameter $key Key of the parameter
     * @param string|int|bool|float|array|null $value The value of the parameter. Set to <code>null</code> to remove it
     * @throws JsonException Thrown when an array cannot be encoded in JSON
     * @see HelperFunctions::toStringValue() Supported data types
     */
    public function setParameter(AParameter $key, $value): void
    {
        $val = HelperFunctions::toStringValue($value);
        if (is_null($val)) {
            unset($this->parameters[$key->getName()]);
        } else {
            $this->parameters[$key->getName()] = $val;
        }
    }

    /**
     * @return array<string, string> A key-value-map of all parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Sends the request to the analytics endpoint
     *
     * @return bool A boolean, if the request has been processed successfully
     * @see ARequest::setDebug()
     */
    abstract public function send(): bool;

}