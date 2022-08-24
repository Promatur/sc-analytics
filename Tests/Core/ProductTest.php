<?php

namespace Core;

use Money\Currency;
use Money\Money;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\Product;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Product class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class ProductTest extends TestCase
{

    /**
     * Helper function setting properties using reflection.
     *
     * @param Product $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(Product $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Product::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param Product $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(Product $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(Product::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $m = new Money(100, new Currency('EUR'));
        $product = new Product("id", $m, null, "key", "name", "category", "variant", "brand", 10, "coupon");
        self::assertEquals("id", self::get($product, "id"));
        self::assertEquals($m, self::get($product, "price"));
        self::assertNull(self::get($product, "finalPrice"));
        self::assertEquals("key", self::get($product, "key"));
        self::assertEquals("name", self::get($product, "name"));
        self::assertEquals("category", self::get($product, "category"));
        self::assertEquals("variant", self::get($product, "variant"));
        self::assertEquals("brand", self::get($product, "brand"));
        self::assertEquals(10, self::get($product, "quantity"));
        self::assertEquals("coupon", self::get($product, "coupon"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetKey(): void
    {
        $product = new Product("id");
        self::set($product, "key", "value");
        self::assertEquals("value", $product->getKey());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetBrand(): void
    {
        $product = new Product("id");
        self::set($product, "brand", "value");
        self::assertEquals("value", $product->getBrand());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPrice(): void
    {
        $m = new Money(100, new Currency('EUR'));
        $product = new Product("id");
        self::set($product, "price", $m);
        self::assertEquals($m, $product->getPrice());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetFinalPrice(): void
    {
        $m = new Money(100, new Currency('EUR'));
        $product = new Product("id");
        self::set($product, "finalPrice", $m);
        self::assertEquals($m, $product->getFinalPrice());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetId(): void
    {
        $product = new Product("id");
        self::set($product, "id", "value");
        self::assertEquals("value", $product->getId());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetName(): void
    {
        $product = new Product("id");
        self::set($product, "name", "value");
        self::assertEquals("value", $product->getName());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetCoupon(): void
    {
        $product = new Product("id");
        self::set($product, "coupon", "value");
        self::assertEquals("value", $product->getCoupon());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetVariant(): void
    {
        $product = new Product("id");
        self::set($product, "variant", "value");
        self::assertEquals("value", $product->getVariant());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetQuantity(): void
    {
        $product = new Product("id");
        self::set($product, "quantity", 10);
        self::assertEquals(10, $product->getQuantity());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetCategory(): void
    {
        $product = new Product("id");
        self::set($product, "category", "value");
        self::assertEquals("value", $product->getCategory());
    }
}
