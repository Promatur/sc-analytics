<?php

namespace Core;

use Money\Currency;
use Money\Money;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\Product;
use ScAnalytics\Core\Transaction;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Transaction class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class TransactionTest extends TestCase
{

    /**
     * Helper function setting properties using reflection.
     *
     * @param Transaction $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(Transaction $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Transaction::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param Transaction $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(Transaction $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(Transaction::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");

        $this->assertEquals("id", self::get($tx, "id"));
        self::assertEquals($products, self::get($tx, "products"));
        self::assertEquals($shipping, self::get($tx, "shipping"));
        self::assertEquals($taxes, self::get($tx, "taxes"));
        self::assertEquals($discounts, self::get($tx, "discounts"));
        self::assertEquals($total, self::get($tx, "total"));
        self::assertEquals("affiliation", self::get($tx, "affiliation"));
        self::assertEquals("coupon", self::get($tx, "coupon"));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetTotal(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));

        $p = new Money(1234, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");
        self::set($tx, "total", $p);
        $this->assertEquals($p, $tx->getTotal());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetShipping(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));

        $p = new Money(1234, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");
        self::set($tx, "shipping", $p);
        $this->assertEquals($p, $tx->getShipping());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetAffiliation(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));

        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");
        self::set($tx, "affiliation", "aff");
        $this->assertEquals("aff", $tx->getAffiliation());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetCoupon(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));

        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");
        self::set($tx, "coupon", "coup");
        $this->assertEquals("coup", $tx->getCoupon());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetDiscounts(): void
    {

        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));

        $p = new Money(1234, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");
        self::set($tx, "discounts", $p);
        $this->assertEquals($p, $tx->getDiscounts());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetProducts(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");

        $p = [new Product("b")];
        self::set($tx, "products", $p);
        $this->assertEquals($p, $tx->getProducts());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetId(): void
    {
        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");

        self::set($tx, "id", "identifier");
        $this->assertEquals("identifier", $tx->getId());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetTaxes(): void
    {

        $products = [new Product("a")];
        $shipping = new Money(299, new Currency('EUR'));
        $taxes = new Money(434, new Currency('EUR'));
        $discounts = new Money(1000, new Currency('EUR'));
        $total = new Money(4999, new Currency('EUR'));

        $p = new Money(1234, new Currency('EUR'));
        $tx = new Transaction("id", $products, $shipping, $taxes, $discounts, $total, "affiliation", "coupon");
        self::set($tx, "taxes", $p);
        $this->assertEquals($p, $tx->getTaxes());
    }
}