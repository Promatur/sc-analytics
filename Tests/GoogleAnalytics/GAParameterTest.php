<?php

namespace ScAnalytics\Tests\GoogleAnalytics;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\AParameter;
use ScAnalytics\GoogleAnalytics\GAParameter;

/**
 * Tests the GAParameter class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAParameterTest extends TestCase
{

    /**
     * Helper function accessing properties using reflection.
     *
     * @param GAParameter $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(GAParameter $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(AParameter::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param GAParameter $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     * @noinspection PhpSameParameterValueInspection
     */
    private static function set(GAParameter $instance, string $field, $value): void
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
        $class = new ReflectionClass(GAParameter::class);
        $variables = [];
        foreach ($class->getStaticProperties() as $property => $data) {
            $prop = $class->getProperty($property);
            $prop->setAccessible(true);
            /** @var GAParameter $val */
            $val = $prop->getValue();
            self::assertInstanceOf(GAParameter::class, $val);
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
        self::assertEquals("test", self::get(new GAParameter("test"), "name"));
        self::assertEquals("abC", self::get(new GAParameter("abC"), "name"));
        self::assertEquals("", self::get(new GAParameter(""), "name"));
        self::assertEquals(1, self::get(new GAParameter("abc"), "index"));
    }

    /**
     * Null values are excluded by type definition.
     * @throws ReflectionException
     */
    public function testGetName(): void
    {
        $obj = new GAParameter("DeF");
        self::assertEquals("DeF", $obj->getName());
        self::set($obj, "name", "gHi");
        self::assertEquals("gHi", $obj->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithValue(): void
    {
        $obj = new GAParameter("DeF%p1%%p2%");
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
