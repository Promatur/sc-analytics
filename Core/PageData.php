<?php

namespace ScAnalytics\Core;

use ScAnalytics\Tests\Core\PageDataTest;

/**
 * Class PageData. Helper class, which contains page data relevant for analytics requests.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see PageDataTest phpunit test
 */
class PageData
{
    /**
     * @var string Title of the current page
     */
    private $pageTitle;

    /**
     * @var string[]|null Names of the pages in the breadcrumb link path
     */
    private $parents;

    /**
     * @param string $pageTitle Title of the current page
     * @param string[]|null $parents Names of the pages in the breadcrumb link path
     */
    public function __construct(string $pageTitle, ?array $parents = [])
    {
        $this->pageTitle = $pageTitle;
        $this->parents = $parents ?? array();
    }

    /**
     * @return string Title of the current page
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle Title of the current page
     */
    public function setPageTitle(string $pageTitle): void
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string[]|null Names of the pages in the breadcrumb link path
     */
    public function getParents(): ?array
    {
        return $this->parents;
    }

    /**
     * @param string[]|null $parents Names of the pages in the breadcrumb link path
     */
    public function setParents(?array $parents): void
    {
        $this->parents = $parents;
    }

}