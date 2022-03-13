<?php

namespace ScAnalytics\Tests\Matomo;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\Matomo;
use ScAnalytics\Matomo\Requests\MDownloadRequest;
use ScAnalytics\Matomo\Requests\MEventRequest;
use ScAnalytics\Matomo\Requests\MExceptionRequest;
use ScAnalytics\Matomo\Requests\MLogoutRequest;
use ScAnalytics\Matomo\Requests\MPageViewRequest;
use ScAnalytics\Matomo\Requests\MRequest;
use ScAnalytics\Matomo\Requests\MSearchRequest;
use ScAnalytics\Matomo\Requests\MSocialRequest;
use ScAnalytics\Matomo\Requests\MTimingRequest;

/**
 * Tests the Matomo class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MatomoTest extends TestCase
{

    public function test__construct(): void
    {
        new Matomo();
        $this->expectNotToPerformAssertions();
    }

    public function testSetVariable(): void
    {
        Matomo::setVariable("a", "b");
        self::assertEquals(["a" => "b"], $_SESSION['matomo']);
        Matomo::setVariable("c", "d");
        self::assertEquals(["a" => "b", "c" => "d"], $_SESSION['matomo']);
        Matomo::setVariable("a", "f");
        self::assertEquals(["a" => "f", "c" => "d"], $_SESSION['matomo']);
    }

    public function testGetVariable(): void
    {
        self::assertNull(Matomo::getVariable("a"));
        $_SESSION['matomo'] = ["a" => "b"];
        self::assertEquals("b", Matomo::getVariable("a"));
        self::assertNull(Matomo::getVariable("c"));
    }

    public function testGetName(): void
    {
        $matomo = new Matomo();
        self::assertEquals("Matomo", $matomo->getName());
    }

    public function testIsAvailable(): void
    {
        $matomo = new Matomo();
        self::assertFalse($matomo->isAvailable());
        AnalyticsConfig::$matomoID = "2";
        self::assertFalse($matomo->isAvailable());
        AnalyticsConfig::$matomoEndpoint = "https://example.com/";
        self::assertTrue($matomo->isAvailable());
    }

    public function testLoadJS(): void
    {
        Analytics::init();
        $matomo = new Matomo();
        $pageData = new PageData("title");

        self::assertEmpty($matomo->loadJS($pageData));

        AnalyticsConfig::$matomoID = "2";
        AnalyticsConfig::$matomoEndpoint = "https://example.com";

        $code = $matomo->loadJS($pageData);
        $pageViewId = MRequest::getPageViewID() ?? "";
        self::assertStringContainsString('<script', $code);
        self::assertStringContainsString('data-pv="' . $pageViewId . '"', $code);
        self::assertStringContainsString('id="_matomo"', $code);
        self::assertStringContainsString("/matomo.min.js", $code);
        self::assertStringContainsString('data-url="https://example.com/"', $code);
        self::assertStringContainsString('data-siteid="2"', $code);
        self::assertStringContainsString('data-visitorid="' . Matomo::getVisitorId() . '"', $code);
        self::assertStringContainsString('defer', $code);
    }

    public function testGetVisitorId(): void
    {
        Analytics::init();
        /** @var string $visitorId */
        $visitorId = Matomo::getVisitorId();
        self::assertNotEmpty($visitorId);
        self::assertEquals(Matomo::LENGTH_VISITOR_ID, strlen($visitorId));
        self::assertEquals(["visitorId" => $visitorId], $_SESSION['matomo']);

        $_SESSION['matomo'] = ["visitorId" => "abc"];
        self::assertEquals("abc", Matomo::getVisitorId());
    }

    public function testEvent(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MEventRequest::class, $ga->event(false, "category", "action"));
    }

    public function testException(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MExceptionRequest::class, $ga->exception());
    }

    public function testPageView(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MPageViewRequest::class, $ga->pageView(null));
    }

    public function testSocial(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MSocialRequest::class, $ga->social("Twitter", "tweet", "https://promatur.com"));
    }

    public function testTiming(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MTimingRequest::class, $ga->timing("Assets", "script.js", 13));
    }

    public function testSearch(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MSearchRequest::class, $ga->search(null, "promatur", 27));
    }

    public function testLogout(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MLogoutRequest::class, $ga->logout());
    }

    public function testDownload(): void
    {
        $ga = new Matomo();
        self::assertInstanceOf(MDownloadRequest::class, $ga->download("image.jpg"));
    }

    protected function setUp(): void
    {
        $_SESSION = [];
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        AnalyticsConfig::$matomoID = "";
        AnalyticsConfig::$matomoEndpoint = "";
        self::setAnalytics("analytics", null);
        self::setAnalytics("analyticsList", []);
        self::setAnalytics("scope", new Scope());
        unset($_SESSION['matomo']);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function setAnalytics(string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Analytics::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($value);
    }
}
