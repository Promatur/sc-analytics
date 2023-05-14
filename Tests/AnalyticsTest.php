<?php

namespace ScAnalytics\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AnalyticsHandler;
use ScAnalytics\Core\Scope;
use ScAnalytics\NoAnalytics\NoAnalytics;
use function PHPUnit\Framework\assertInstanceOf;

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
    public function testGetScope(): void
    {
        $scope = new Scope();
        self::set("scope", $scope);
        self::assertEquals($scope, Analytics::getScope());
    }

    public function testGetAnalyticsList(): void
    {
        Analytics::init();
        $list = Analytics::getAnalyticsList();

        self::assertNotEmpty($list);
        foreach ($list as $item) {
            assertInstanceOf(AnalyticsHandler::class, $item);
        }
        // Check for right order of elements
        self::assertEquals("Matomo", $list[0]->getName());
        self::assertEquals("Google Analytics 4", $list[1]->getName());
        self::assertEquals("Google Analytics", $list[2]->getName());
        self::assertEquals("No", $list[3]->getName());
    }

    protected function setUp(): void
    {
        $mock = $this->getMockBuilder(AnalyticsHandler::class)->getMock();
        $mock->method("getName")
            ->willReturn("Available");
        $mock->method("isAvailable")
            ->willReturn(true);
        $mock->method("loadJS")
            ->willReturn("");
        self::$available = $mock;

        $mock = $this->getMockBuilder(AnalyticsHandler::class)->getMock();
        $mock->method("getName")
            ->willReturn("Unavailable");
        $mock->method("isAvailable")
            ->willReturn(false);
        $mock->method("loadJS")
            ->willReturn("");
        self::$unavailable = $mock;
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
}
