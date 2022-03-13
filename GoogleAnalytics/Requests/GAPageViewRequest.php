<?php


namespace ScAnalytics\GoogleAnalytics\Requests;


use JsonException;
use ScAnalytics\Core\PageData;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Class GAPageViewRequest. Page view measurement allows you to measure the number of views you had for a particular page on your website.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/pages
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#content
 */
class GAPageViewRequest extends GARequest
{

    /**
     * GAPageViewRequest constructor. All other parameters are set by the default constructor.
     * @param PageData|null $pageData Data of the current page
     * @see GARequest::__construct
     */
    public function __construct(?PageData $pageData = null)
    {
        parent::__construct();
        $this->setType("pageview");
        try {
            $this->setParameter(GAParameter::$DOCUMENTTITLE, is_null($pageData) ? ($_GET['page'] ?? null) : $pageData->getPageTitle());
        } catch (JsonException $ignored) {
        }
        $this->updateGenerationTime();
    }

}