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
     * @var String[] A key-value-map of all parameters
     */
    private $parameters = array();

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
     * Sets a parameter of the request. Handles specific data types:
     * <ul>
     * <li>Boolean is converted to 1 or 0</li>
     * <li>Array is encoded in Json</li>
     * <li>Everything else is cast as a string</li>
     * </ul>
     *
     * Passing a null value or an empty array will remove the parameter from the request.
     *
     * @param AParameter $key Key of the parameter
     * @param string|int|bool|float|array|null $value The value of the parameter. Set to <code>null</code> to remove it
     * @throws JsonException Thrown when an array cannot be encoded in JSON
     */
    public function setParameter(AParameter $key, $value): void
    {
        if (((!empty($value)) || !is_array($value)) && !is_null($value)) {
            if (is_bool($value)) {
                $value = $value ? "1" : "0";
            } else if (is_array($value)) {
                $value = json_encode($value, JSON_THROW_ON_ERROR);
            } else {
                $value = (string)$value;
            }
            $this->parameters[$key->getName()] = $value;
        } else {
            unset($this->parameters[$key->getName()]);
        }
    }

    /**
     * Returns the value of a parameter.
     *
     * @param AParameter $key Key of the parameter
     * @return string|null The value of the parameter or <code>null</code> if it does not exist
     */
    public function getParameter(AParameter $key): ?string
    {
        return $this->parameters[$key->getName()] ?? null;
    }

    /**
     * @return String[] A key-value-map of all parameters
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

    /**
     * Gets the URL of the current page and trims trailing slashes.
     * If an override URL is set in a global url, it will be used instead.
     *
     * @return string The URL of the current page
     */
    public function getPageUrl(): string
    {
        if (!empty($GLOBALS['sca_override_url'])) {
            $url = $GLOBALS['sca_override_url'];
        } else {
            $url = HelperFunctions::getURL();
        }
        return rtrim($url, '/');
    }

}