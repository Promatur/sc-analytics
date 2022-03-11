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
use ScAnalytics\Matomo\Requests\MRequest;

class MatomoTest extends TestCase
{

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
        AnalyticsConfig::$matomoToken = "";
        self::setAnalytics("analytics", null);
        self::setAnalytics("analyticsList", []);
        self::setAnalytics("scope", new Scope());
        unset($_SESSION['matomo']);
    }

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
        self::assertStringContainsString("/matomo.js", $code);
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
}
