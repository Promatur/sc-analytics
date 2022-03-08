<?php

namespace ScAnalytics\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Scope;
use ScAnalytics\NoAnalytics\NoAnalytics;

/**
 * Tests the Analytics class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see Analytics Tested class
 */
class AnalyticsTest extends TestCase
{

    /**
     * @var AnalyticsHandler Available analytics handler
     */
    private static $available;

    /**
     * @var AnalyticsHandler Unavailable analytics handler
     */
    private static $unavailable;

    /**
     * Helper function accessing properties using reflection.
     *
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(string $field)
    {
        $apiDataClass = new ReflectionClass(Analytics::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue();
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Analytics::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($value);
    }

    protected function setUp(): void
    {
        self::$available = new class implements AnalyticsHandler {

            public function getName(): string
            {
                return "Available";
            }

            public function isAvailable(): bool
            {
                return true;
            }

            public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
            {
                return "";
            }
        };

        self::$unavailable = new class implements AnalyticsHandler {

            public function getName(): string
            {
                return "Available";
            }

            public function isAvailable(): bool
            {
                return false;
            }

            public function loadJS(PageData $pageData, ?ARequest $pageViewRequest = null): string
            {
                return "";
            }
        };
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        self::set("analytics", null);
        self::set("analyticsList", []);
        self::set("scope", new Scope());
        AnalyticsConfig::$preferred = "auto";
    }

    /**
     * @throws ReflectionException
     */
    public function testAuto(): void
    {
        self::assertNull(self::get("analytics"));

        self::set("analyticsList", [self::$available, self::$unavailable]);
        Analytics::auto();
        /** @var AnalyticsHandler $active */
        $active = self::get("analytics");
        self::assertEquals("Available", $active->getName());

        self::set("analytics", null);
        self::set("analyticsList", [self::$unavailable, self::$available]);
        Analytics::auto();
        /** @var AnalyticsHandler $active */
        $active = self::get("analytics");
        self::assertEquals("Available", $active->getName());

        self::set("analytics", null);
        self::set("analyticsList", [self::$unavailable]);
        Analytics::auto();
        self::assertNull(self::get("analytics"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGet(): void
    {
        // Not initialized, so NoAnalytics
        self::assertInstanceOf(NoAnalytics::class, Analytics::get());

        self::set("analytics", self::$available);
        $active = Analytics::get();
        self::assertEquals("Available", $active->getName());

        self::set("analytics", null);
        self::set("analyticsList", [self::$unavailable, self::$available]);
        $active = Analytics::get();
        self::assertEquals("Available", $active->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testInit(): void
    {
        self::assertEmpty(self::get("analyticsList"));
        Analytics::init();
        self::assertNotEmpty(self::get("analyticsList"));
        self::assertInstanceOf(NoAnalytics::class, self::get("analytics"));
        self::assertInstanceOf(Scope::class, self::get("scope"));

        $scope = new Scope("de-de");
        Analytics::init($scope);
        self::assertEquals($scope, self::get("scope"));
    }

    /**
     * @throws ReflectionException
     */
    public function testCheckStatus(): void
    {
        self::assertNull(self::get("analytics"));
        Analytics::checkStatus();
        self::assertInstanceOf(NoAnalytics::class, self::get("analytics"));

        self::set("analytics", null);
        self::set("analyticsList", [self::$unavailable, self::$available]);
        AnalyticsConfig::$preferred = "auto";
        Analytics::checkStatus();
        /** @var AnalyticsHandler $active */
        $active = self::get("analytics");
        self::assertEquals("Available", $active->getName());

        self::set("analytics", null);
        self::set("analyticsList", [self::$unavailable, self::$available]);
        AnalyticsConfig::$preferred = "unavailable";
        Analytics::checkStatus();
        self::assertInstanceOf(NoAnalytics::class, self::get("analytics"));

        self::set("analytics", null);
        self::set("analyticsList", [self::$unavailable, self::$available]);
        AnalyticsConfig::$preferred = "available";
        Analytics::checkStatus();
        /** @var AnalyticsHandler $active */
        $active = self::get("analytics");
        self::assertEquals("Available", $active->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetScope(): void {
        $scope = new Scope();
        self::set("scope", $scope);
        self::assertEquals($scope, Analytics::getScope());
    }
}
