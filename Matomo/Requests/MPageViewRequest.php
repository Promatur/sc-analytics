<?php


namespace ScAnalytics\Matomo\Requests;


use ScAnalytics\Core\PageData;

/**
 * Class MPageViewRequest. Page view measurement allows you to measure the number of views you had for a particular page on your website.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MPageViewRequest extends MRequest
{

    /**
     * MPageViewRequest constructor.
     * @param PageData|null $pageData Data of the current page
     */
    public function __construct(?PageData $pageData = null)
    {
        MRequest::generatePageViewID();
        parent::__construct();
        if (is_null($pageData)) {
            $this->setPageTitle($_GET['page'] ?? "-");
        } else {
            $this->setPageTitle($pageData->getPageTitle(), $pageData->getParents() ?? []);
        }
        $this->updateGenerationTime();
    }
}