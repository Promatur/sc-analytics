<?php

namespace ScAnalytics\Tests\NoAnalytics;

use PHPUnit\Framework\TestCase;
use ScAnalytics\Core\PageData;
use ScAnalytics\NoAnalytics\NoAnalytics;
use ScAnalytics\NoAnalytics\NoRequest;

/**
 * Tests the NoAnalytics class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see NoAnalytics Tested class
 */
class NoAnalyticsTest extends TestCase
{

    public function testLoadJS(): void
    {
        $pageData = new PageData("");
        $analytics = new NoAnalytics();
        self::assertEmpty($analytics->loadJS($pageData));
        self::assertEmpty($analytics->loadJS($pageData, new NoRequest()));
    }

    public function testIsAvailable(): void
    {
        $analytics = new NoAnalytics();
        self::assertTrue($analytics->isAvailable());
    }

    public function testGetName(): void
    {
        $analytics = new NoAnalytics();
        self::assertEquals("No", $analytics->getName());
    }

    public function testEvent(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->event(false, "category", "action"));
    }

    public function testException(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->exception());
    }

    public function testPageView(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->pageView(null));
    }

    public function testSocial(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->social("Twitter", "tweet", "https://promatur.com"));
    }

    public function testTiming(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->timing("Assets", "script.js", 13));
    }

    public function testSearch(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->search(null, "promatur", 27));
    }

    public function testLogout(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->logout());
    }

    public function testDownload(): void
    {
        $ga = new NoAnalytics();
        self::assertInstanceOf(NoRequest::class, $ga->download("image.jpg"));
    }
}
