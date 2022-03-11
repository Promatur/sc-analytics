<?php


namespace ScAnalytics\Matomo\Requests;


/**
 * Class MTimingRequest. Reducing page load time can improve the overall user experience of a site.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MTimingRequest extends MEventRequest
{

    /**
     * MTimingRequest constructor.
     * @param string $group A string for categorizing all user timing variables into logical groups (e.g. 'JS Dependencies')
     * @param string $name A string to identify the variable being recorded (e.g. 'load')
     * @param int $milliseconds The number of milliseconds in elapsed time
     * @param string|null $label A string that can be used to add flexibility in visualizing user timings in the reports (e.g. 'Google CDN')
     */
    public function __construct(string $group, string $name, int $milliseconds, ?string $label = null)
    {
        parent::__construct("Timing - " . $group, $name, $label, $milliseconds);
    }

}