<?php


namespace ScAnalytics\Matomo\Requests;

use JsonException;
use ScAnalytics\Core\PageData;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MSearchRequest. Site Search tracking allows tracking how people use the website’s internal search engine.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://matomo.org/docs/site-search/ Matomo Site Search documentation
 */
class MSearchRequest extends MPageViewRequest
{
    /**
     * MSearchRequest constructor.
     * @param PageData|null $pageData The data of the viewed page
     * @param string $keyword The keyword of the search request
     * @param int $results The amount of results of the search request
     * @param string $category The category of the search request (for example: products, help articles, ...)
     */
    public function __construct(?PageData $pageData, string $keyword, int $results, string $category = "all")
    {
        parent::__construct($pageData);
        try {
            $this->setParameter(MParameter::$SEARCHKEYWORD, $keyword);
            $this->setParameter(MParameter::$SEARCHCOUNT, $results);
            $this->setParameter(MParameter::$SEARCHCATEGORY, $category);
        } catch (JsonException $ignored) {
        }
    }

}