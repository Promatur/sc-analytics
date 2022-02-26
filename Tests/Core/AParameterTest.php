<?php

namespace ScAnalytics\Tests\Core;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\AParameter;
use PHPUnit\Framework\TestCase;

/**
 * Tests the AParameter class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see AParameter Tested class
 */
class AParameterTest extends TestCase
{

    /**
     * Helper function accessing properties using reflection.
     *
     * @param AParameter $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(AParameter $instance, string $field) {
        $apiDataClass = new ReflectionClass(AParameter::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param AParameter $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     * @noinspection PhpSameParameterValueInspection
     */
    private static function set(AParameter $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(AParameter::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * Null values are excluded by type definition.
     *
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        self::assertEquals("test", self::get(new AParameter("test"), "name"));
        self::assertEquals("abC", self::get(new AParameter("abC"), "name"));
        self::assertEquals("", self::get(new AParameter(""), "name"));
        self::assertEquals(1, self::get(new AParameter("abc"), "index"));
    }

    /**
     * Null values are excluded by type definition.
     * @throws ReflectionException
     */
    public function testGetName(): void
    {
        $obj = new AParameter("DeF");
        self::assertEquals("DeF", $obj->getName());
        self::set($obj, "name", "gHi");
        self::assertEquals("gHi", $obj->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithValue(): void
    {
        $obj = new AParameter("DeF%p1%%p2%");
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
