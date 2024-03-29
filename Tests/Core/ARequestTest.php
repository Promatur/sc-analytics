<?php

namespace ScAnalytics\Tests\Core;

use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AParameter;
use ScAnalytics\Core\ARequest;
use ScAnalytics\Core\HelperFunctions;

class ARequestTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        AnalyticsConfig::$debug = true;
        $stub = $this->getMockForAbstractClass(ARequest::class);
        self::assertTrue(self::get($stub, "debug"));
        self::assertIsArray(self::get($stub, "parameters"));
        self::assertEmpty(self::get($stub, "parameters"));

        AnalyticsConfig::$debug = false;
        $stub = $this->getMockForAbstractClass(ARequest::class);
        self::assertFalse(self::get($stub, "debug"));
        self::assertIsArray(self::get($stub, "parameters"));
        self::assertEmpty(self::get($stub, "parameters"));
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param ARequest $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(ARequest $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(ARequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function testSetDebug(): void
    {
        $stub = $this->getMockForAbstractClass(ARequest::class);
        $stub->setDebug(true);
        self::assertTrue(self::get($stub, "debug"));

        $stub->setDebug(false);
        self::assertFalse(self::get($stub, "debug"));
    }

    /**
     * @throws ReflectionException
     */
    public function testIsDebug(): void
    {
        $stub = $this->getMockForAbstractClass(ARequest::class);
        self::set($stub, "debug", true);
        self::assertTrue($stub->isDebug());

        self::set($stub, "debug", false);
        self::assertFalse($stub->isDebug());
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param ARequest $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(ARequest $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(ARequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * @throws JsonException
     * @throws ReflectionException
     */
    public function testSetParameter(): void
    {
        $param = new class extends AParameter {
            public function __construct()
            {
                parent::__construct("test");
            }
        };

        $stub = $this->getMockForAbstractClass(ARequest::class);

        $stub->setParameter($param, array("a" => "b"));
        self::assertEquals(['test' => '{"a":"b"}'], self::get($stub, "parameters"));

        $stub->setParameter($param, 20);
        self::assertEquals(['test' => '20'], self::get($stub, "parameters"));

        $stub->setParameter($param, 0);
        self::assertEquals(['test' => '0'], self::get($stub, "parameters"));

        $stub->setParameter($param, "abc");
        self::assertEquals(['test' => 'abc'], self::get($stub, "parameters"));

        $stub->setParameter($param, true);
        self::assertEquals(['test' => '1'], self::get($stub, "parameters"));

        $stub->setParameter($param, false);
        self::assertEquals(['test' => '0'], self::get($stub, "parameters"));

        $stub->setParameter($param, null);
        self::assertEmpty(self::get($stub, "parameters"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetParameter(): void {
        $paramA = new class extends AParameter {
            public function __construct()
            {
                parent::__construct("test");
            }
        };
        $paramB = new class extends AParameter {
            public function __construct()
            {
                parent::__construct("test2");
            }
        };

        $stub = $this->getMockForAbstractClass(ARequest::class);
        self::set($stub, "parameters", [$paramA->getName() => "b"]);

        self::assertEquals("b", $stub->getParameter($paramA));
        self::assertNull($stub->getParameter($paramB));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetParameters(): void
    {
        $stub = $this->getMockForAbstractClass(ARequest::class);
        self::set($stub, "parameters", ["a" => "b", "c" => "d"]);
        self::assertEquals(["a" => "b", "c" => "d"], $stub->getParameters());
    }

    public function testGetUrl(): void
    {
        $stub = $this->getMockForAbstractClass(ARequest::class);

        $_SERVER['HTTPS'] = "on";
        $_SERVER['SERVER_NAME'] = "promatur.com";
        $_SERVER['REQUEST_URI'] = "/abc";
        self::assertEquals("https://promatur.com/abc", $stub->getPageUrl());

        $_SERVER['HTTPS'] = "on";
        $_SERVER['SERVER_NAME'] = "promatur.com";
        $_SERVER['REQUEST_URI'] = "/abcd/";
        self::assertEquals("https://promatur.com/abcd", $stub->getPageUrl());

        $_SERVER['HTTPS'] = "on";
        $_SERVER['SERVER_NAME'] = "promatur.com";
        $_SERVER['REQUEST_URI'] = "/abcd/";
        $GLOBALS['sca_override_url'] = "https://promatur.com/override";
        self::assertEquals("https://promatur.com/override", $stub->getPageUrl());
    }

    protected function tearDown(): void
    {
        AnalyticsConfig::$debug = false;
        unset($GLOBALS['sca_override_url']);
    }
}
