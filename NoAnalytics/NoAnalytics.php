<?php


namespace ScAnalytics\NoAnalytics;


use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\PageData;

/**
 * Class NoAnalytics. This class is a dummy analytics handler, if no other handler is available.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class NoAnalytics implements AnalyticsHandler
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "No";
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
    {
        return "";
    }

    // - Requests

    /**
     * @inheritDoc
     */
    public function event(bool $interactive, string $category, string $action, ?string $label = null, ?int $value = null): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function exception(?string $description = null, bool $fatal = false): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function pageView(?PageData $pageData): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function social(string $network, string $action, string $target): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function timing(string $group, string $name, int $milliseconds, ?string $label = null): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function search(?PageData $pageData, string $keyword, int $results, string $category = "all"): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function logout(): ARequest
    {
        return new NoRequest();
    }

    /**
     * @inheritDoc
     */
    public function download(string $fileName, ?int $size = null): ARequest
    {
        return new NoRequest();
    }
}