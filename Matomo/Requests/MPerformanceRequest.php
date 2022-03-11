<?php


namespace ScAnalytics\Matomo\Requests;


use JsonException;
use ScAnalytics\Core\PageData;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MPerformanceRequest. Sets timings for various browser performance metrics.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MPerformanceRequest extends MPageViewRequest
{

    /**
     * MPerformanceRequest constructor.
     * @param PageData|null $pageData The data of the page
     * @param null|int $network Network time in ms (connectEnd – fetchStart)
     * @param null|int $server Server time in ms (responseStart – requestStart)
     * @param null|int $transfer Transfer time in ms (responseEnd – responseStart)
     * @param null|int $domProcessing DOM Processing to Interactive time in ms (domInteractive – domLoading)
     * @param null|int $domCompletion DOM Interactive to Complete time in ms (domComplete – domInteractive)
     * @param null|int $onLoad Onload time in ms (loadEventEnd – loadEventStart)
     */
    public function __construct(?PageData $pageData = null, ?int $network = null, ?int $server = null, ?int $transfer = null, ?int $domProcessing = null, ?int $domCompletion = null, ?int $onLoad = null)
    {
        parent::__construct($pageData);
        try {
            $this->setParameter(MParameter::$NETWORKTIME, $network);
            $this->setParameter(MParameter::$SERVERTIME, $server);
            $this->setParameter(MParameter::$TRANSFERTIME, $transfer);
            $this->setParameter(MParameter::$DOMPROCESSINGTIME, $domProcessing);
            $this->setParameter(MParameter::$DOMCOMPLETIONTIME, $domCompletion);
            $this->setParameter(MParameter::$ONLOADTIME, $onLoad);
        } catch (JsonException $ignored) {
        }
    }

}