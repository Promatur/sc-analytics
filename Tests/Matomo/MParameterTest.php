<?php

namespace Matomo;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\AParameter;
use ScAnalytics\Matomo\MParameter;

class MParameterTest extends TestCase
{

    /**
     * Helper function accessing properties using reflection.
     *
     * @param MParameter $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(MParameter $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(AParameter::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param MParameter $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     * @noinspection PhpSameParameterValueInspection
     */
    private static function set(MParameter $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(AParameter::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * Checks if <code>init()</code> has been executed successfully during class loading.
     *
     * @throws ReflectionException
     */
    public function testInit(): void
    {
        $class = new ReflectionClass(MParameter::class);
        $variables = [];
        foreach ($class->getStaticProperties() as $property => $data) {
            $prop = $class->getProperty($property);
            $prop->setAccessible(true);
            /** @var MParameter $val */
            $val = $prop->getValue();
            self::assertInstanceOf(MParameter::class, $val);
            self::assertNotEmpty($val->getName());
            $variables[] = $val->getName();
        }
        // Check for doubles
        self::assertCount(count($variables), array_flip($variables), "Parameter key used multiple times.");
    }

    /**
     * Null values are excluded by type definition.
     *
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        self::assertEquals("test", self::get(new MParameter("test"), "name"));
        self::assertEquals("abC", self::get(new MParameter("abC"), "name"));
        self::assertEquals("", self::get(new MParameter(""), "name"));
        self::assertEquals(1, self::get(new MParameter("abc"), "index"));
    }

    /**
     * Null values are excluded by type definition.
     * @throws ReflectionException
     */
    public function testGetName(): void
    {
        $obj = new MParameter("DeF");
        self::assertEquals("DeF", $obj->getName());
        self::set($obj, "name", "gHi");
        self::assertEquals("gHi", $obj->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithValue(): void
    {
        $obj = new MParameter("DeF%p1%%p2%");
        self::assertEquals(1, self::get($obj, "index"));
        $val = $obj->withValue("q3");
        self::assertEquals(2, self::get($val, "index"));
        self::assertNotEquals($obj, $val);
        self::assertEquals("DeFq3%p2%", self::get($val, "name"));
        $val2 = $val->withValue("x7");
        self::assertEquals(3, self::get($val, "index"));
        self::assertEquals($val, $val2);
        self::assertEquals("DeFq3x7", self::get($val, "name"));
    }
}
