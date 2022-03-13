<?php


namespace ScAnalytics\GoogleAnalytics\Requests;



use JsonException;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Class GAExceptionRequest. Exception tracking allows you to measure the number and type of crashes or errors that occur on your property.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/exceptions
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#exception
 */
class GAExceptionRequest extends GARequest
{

    /**
     * GAExceptionRequest constructor.
     * @param string|null $description A description of the exception
     * @param bool|null $fatal true if the exception was fatal
     */
    public function __construct(?string $description = null, ?bool $fatal = null)
    {
        parent::__construct();
        $this->setType("exception");
        try {
            $this->setParameter(GAParameter::$EXCEPTIONDESCRIPTION, $description);
            $this->setParameter(GAParameter::$EXCEPTIONFATAL, $fatal);
        } catch (JsonException $e) {
        }
    }

}