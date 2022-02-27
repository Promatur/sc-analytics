<?php

namespace ScAnalytics\Matomo;

use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\PageData;

/**
 * Class Matomo. The matomo analytics handler handles the integration of the Matomo analytics platform.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://matomo.org Matomo website
 */
class Matomo implements AnalyticsHandler
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "Matomo";
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(): bool
    {
        return false;// TODO: Implement isAvailable() method.
    }

    /**
     * @inheritDoc
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
    {
        return "";// TODO: Implement loadJS() method.
    }
}