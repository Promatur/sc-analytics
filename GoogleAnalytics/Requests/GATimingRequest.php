<?php


namespace ScAnalytics\GoogleAnalytics\Requests;


use JsonException;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Class GATimingRequest.
 * Reducing page load time can improve the overall user experience of a site.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/user-timings
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#timing
 */
class GATimingRequest extends GARequest
{

    /**
     * GATimingRequest constructor.
     * @param string $group A string for categorizing all user timing variables into logical groups (e.g. 'JS Dependencies')
     * @param string $name A string to identify the variable being recorded (e.g. 'load')
     * @param int $milliseconds The number of milliseconds in elapsed time to report to Google Analytics (e.g. 20)
     * @param string|null $label A string that can be used to add flexibility in visualizing user timings in the reports (e.g. 'Google CDN')
     */
    public function __construct(string $group, string $name, int $milliseconds, ?string $label = null)
    {
        parent::__construct();
        $this->setType("timing");
        try {
            $this->setParameter(GAParameter::$TIMINGCATEGORY, $group);
            $this->setParameter(GAParameter::$TIMINGVARIABLE, $name);
            $this->setParameter(GAParameter::$TIMINGTIME, $milliseconds);
            $this->setParameter(GAParameter::$TIMINGLABEL, $label);
        } catch (JsonException $ignored) {
        }
    }

}