<?php


namespace ScAnalytics\Matomo\Requests;


use JsonException;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MExceptionRequest. Exception tracking allows you to measure the number and type of crashes or errors that occur on your property. Uses events to track exceptions.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MExceptionRequest extends MRequest
{
    /**
     * MExceptionRequest constructor.
     * @param string|null $description A description of the exception
     * @param bool $fatal true if the exception was fatal
     */
    public function __construct(?string $description = null, bool $fatal = false)
    {
        parent::__construct();
        try {
            $this->setParameter(MParameter::$CUSTOMACTION, true);
            $this->setParameter(MParameter::$ERRORMESSAGE, $description ?? "An unknown error occurred");
            $this->setParameter(MParameter::$ERRORTYPE, $fatal ? "Fatal" : "Non-fatal");
        } catch (JsonException $ignored) {
        }
    }

}