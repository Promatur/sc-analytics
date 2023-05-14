<?php

namespace ScAnalytics\GoogleAnalytics4\Requests;

use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\GoogleAnalytics4\Events\GA4PageViewEvent;
use ScAnalytics\GoogleAnalytics4\Events\GA4SessionStartEvent;

/**
 * Class GA4PageViewRequest. Page view measurement allows you to measure the number of views you had for a particular page on your website.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GA4PageViewRequest extends GA4Request
{

    /**
     * All other parameters are set by the default constructor.
     * @param PageData|null $pageData Data of the current page
     * @see GARequest::__construct
     */
    public function __construct(?PageData $pageData = null)
    {
        parent::__construct();
        $title = is_null($pageData) ? ($_GET['page'] ?? null) : $pageData->getPageTitle();
        $this->addEvent(new GA4PageViewEvent(HelperFunctions::getURL(), $title, $_SERVER['HTTP_REFERER'] ?? ""));
        $this->updateGenerationTime();
    }

}