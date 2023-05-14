<?php

namespace Matomo\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\ECommerce\MECommerceRequest;

/**
 * Tests the MECommerceRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MECommerceRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init(new Scope(null, [], false, null, null, 1661360288));
        $total = new Money(2000, new Currency("EUR"));
        $subTotal = new Money(1900, new Currency("EUR"));
        $tax = new Money(20, new Currency("EUR"));
        $shipping = new Money(80, new Currency("EUR"));
        $discount = new Money(200, new Currency("EUR"));
        $products = [new Product("product1")];
        $req = new MECommerceRequest($total, $subTotal, $tax, $shipping, $discount, $products);

        self::assertEquals(0, $req->getParameters()[MParameter::$CONVERSIONGOAL->getName()]);
        self::assertEquals("20.00", $req->getParameters()[MParameter::$REVENUE->getName()]);
        self::assertEquals("19.00", $req->getParameters()[MParameter::$SUBTOTAL->getName()]);
        self::assertEquals("0.20", $req->getParameters()[MParameter::$TAX->getName()]);
        self::assertEquals("0.80", $req->getParameters()[MParameter::$SHIPPING->getName()]);
        self::assertEquals("2.00", $req->getParameters()[MParameter::$DISCOUNT->getName()]);
        self::assertEquals(1661360288, $req->getParameters()[MParameter::$LASTORDERTIMESTAMP->getName()]);
        self::assertEquals('[["product1",null,null,null,null]]', $req->getParameters()[MParameter::$ECITEMS->getName()]);
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        self::set("analytics", null);
        self::set("analyticsList", []);
        self::set("scope", new Scope());
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Analytics::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($value);
    }
}
