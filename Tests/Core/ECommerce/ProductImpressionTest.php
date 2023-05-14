<?php

namespace Core\ECommerce;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\ECommerce\ProductImpression;
use PHPUnit\Framework\TestCase;

/**
 * Tests the ProductImpression class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class ProductImpressionTest extends TestCase
{

    /**
     * Helper function setting properties using reflection.
     *
     * @param ProductImpression $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(ProductImpression $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(ProductImpression::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param ProductImpression $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(ProductImpression $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(ProductImpression::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $p = new Product("p1");
        $imp = new ProductImpression(2, $p, ["dim1", "dim2"], [2, 5]);
        $this->assertEquals(2, self::get($imp, "position"));
        self::assertEquals($p, self::get($imp, "product"));
        self::assertEquals(["dim1", "dim2"], self::get($imp, "dimensions"));
        self::assertEquals([2, 5], self::get($imp, "metrics"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPosition(): void
    {
        $imp = new ProductImpression(2, new Product("p1"));
        self::set($imp, "position", 1);
        $this->assertEquals(1, $imp->getPosition());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetId(): void
    {
        $p = new Product("p2");
        $imp = new ProductImpression(2, new Product("p1"));
        self::set($imp, "product", $p);
        self::assertEquals($p, $imp->getProduct());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetDimensions(): void
    {
        $imp = new ProductImpression(2, new Product("p1"));
        self::set($imp, "dimensions", ["dim1", "dim2"]);
        self::assertEquals(["dim1", "dim2"], $imp->getDimensions());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetMetrics(): void
    {
        $imp = new ProductImpression(2, new Product("p1"));
        self::set($imp, "metrics", [2, 5]);
        self::assertEquals([2, 5], $imp->getMetrics());
    }
}
