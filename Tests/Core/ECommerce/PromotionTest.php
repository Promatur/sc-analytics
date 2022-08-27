<?php

namespace Core\ECommerce;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\ECommerce\Promotion;

/**
 * Tests the Promotion class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class PromotionTest extends TestCase
{

    /**
     * Helper function setting properties using reflection.
     *
     * @param Promotion $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(Promotion $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Promotion::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param Promotion $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(Promotion $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(Promotion::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $promo = new Promotion("id", "name", "creative", "position");
        $this->assertEquals("id", self::get($promo, "id"));
        $this->assertEquals("name", self::get($promo, "name"));
        $this->assertEquals("creative", self::get($promo, "creative"));
        $this->assertEquals("position", self::get($promo, "position"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetCreative(): void
    {
        $promo = new Promotion("id", "name", "creative", "position");
        self::set($promo, "creative", "newCreative");
        $this->assertEquals("newCreative", $promo->getCreative());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPosition(): void
    {
        $promo = new Promotion("id", "name", "creative", "position");
        self::set($promo, "position", "newPosition");
        $this->assertEquals("newPosition", $promo->getPosition());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetName(): void
    {
        $promo = new Promotion("id", "name", "creative", "position");
        self::set($promo, "name", "newName");
        $this->assertEquals("newName", $promo->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetId(): void
    {
        $promo = new Promotion("id", "name", "creative", "position");
        self::set($promo, "id", "newId");
        $this->assertEquals("newId", $promo->getId());
    }
}
