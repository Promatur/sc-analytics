<?php

namespace GoogleAnalytics4\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics4\Events\GA4SignUpEvent;
use ScAnalytics\GoogleAnalytics4\Requests\GA4PageViewRequest;
use ScAnalytics\GoogleAnalytics4\Requests\GA4Request;

class GA4RequestTest extends TestCase
{

    public function testSetUserIdentifier(): void
    {

    }

    public function testUpdateGenerationTime(): void
    {

    }

    public function testAddEvent(): void
    {

    }

    public function testJsonSerialize(): void
    {
        $req = new GA4Request();
        $req->addEvent(new GA4SignUpEvent());
        $result = $req->jsonSerialize();
        self::assertArrayHasKey('client_id', $result);
        self::assertEquals('1', $result['non_personalized_ads']);
        self::assertNotEmpty($result['events']);
    }

    protected function setUp(): void
    {
        AnalyticsConfig::$googleAnalytics4 = ["G-0000000000" => "nUU5MATPyXQfZwUzGStBmb"];
        Analytics::init();
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        AnalyticsConfig::$debug = false;
        AnalyticsConfig::$googleAnalytics4 = [];
        self::setAnalytics("analytics", null);
        self::setAnalytics("analyticsList", []);
        self::setAnalytics("scope", new Scope());
        unset($GLOBALS['start_time']);
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
