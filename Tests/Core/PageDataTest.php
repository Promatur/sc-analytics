<?php

namespace ScAnalytics\Tests\Core;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\PageData;

/**
 * Tests the PageData class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see PageData Tested class
 */
class PageDataTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $obj = new PageData("abc");
        self::assertEquals("abc", self::get($obj, "pageTitle"));
        self::assertNotNull(self::get($obj, "parents"));
        self::assertEmpty(self::get($obj, "parents"));

        $obj = new PageData("abc", null);
        self::assertEquals("abc", self::get($obj, "pageTitle"));
        self::assertNotNull(self::get($obj, "parents"));
        self::assertEmpty(self::get($obj, "parents"));

        $obj = new PageData("abc", ["abc", "def"]);
        self::assertEquals("abc", self::get($obj, "pageTitle"));
        self::assertEquals(["abc", "def"], self::get($obj, "parents"));
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param PageData $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(PageData $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(PageData::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function testSetPageTitle(): void
    {
        $obj = new PageData("abc");
        self::assertEquals("abc", self::get($obj, "pageTitle"));

        $obj->setPageTitle("def");
        self::assertEquals("def", self::get($obj, "pageTitle"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPageTitle(): void
    {
        $obj = new PageData("abc");
        self::assertEquals("abc", self::get($obj, "pageTitle"));

        self::set($obj, "pageTitle", "def");
        self::assertEquals("def", $obj->getPageTitle());
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param PageData $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(PageData $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(PageData::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * @throws ReflectionException
     */
    public function testSetParents(): void
    {
        $obj = new PageData("abc");
        self::assertEmpty(self::get($obj, "parents"));

        $obj->setParents(["ghi"]);
        self::assertEquals(["ghi"], self::get($obj, "parents"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetParents(): void
    {
        $obj = new PageData("abc");
        self::assertEmpty(self::get($obj, "parents"));

        self::set($obj, "parents", ["ghi"]);
        self::assertEquals(["ghi"], $obj->getParents());
    }
}
