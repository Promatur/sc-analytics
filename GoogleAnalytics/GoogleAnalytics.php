<?php

namespace ScAnalytics\GoogleAnalytics;

use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\PageData;

/**
 * Class GoogleAnalytics. Responsible for managing Google Analytics.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://analytics.google.com/ Google Analytics website
 */
class GoogleAnalytics implements AnalyticsHandler
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "Google Analytics";
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