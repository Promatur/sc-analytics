<?php

namespace Core;

use Error;
use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\AParameter;
use ScAnalytics\Core\ARequest;

class ARequestTest extends TestCase
{

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

    protected function tearDown(): void
    {
        AnalyticsConfig::$debug = false;
    }

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

        $this->expectException(JsonException::class);
        $stub->setParameter($param, [$stub]);
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
}
