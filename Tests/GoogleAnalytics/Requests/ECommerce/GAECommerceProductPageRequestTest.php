<?php

namespace GoogleAnalytics\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Product;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceProductClickRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceProductPageRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GAECommerceProductClickRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommerceProductPageRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new GAECommerceProductPageRequest(new Product("id", new Money(300, new Currency("EUR")), new Money(250, new Currency("EUR")), "key", "name", "category", "variant", "brand", 2, "coupon"));

        self::assertEquals("pageview", $req->getParameters()[GAParameter::$TYPE->getName()]);

        self::assertEquals("detail", $req->getParameters()[GAParameter::$PRODUCTACTION->getName()]);
        self::assertEquals("USD", $req->getParameters()[GAParameter::$CURRENCY->getName()]);

        self::assertEquals("id", $req->getParameters()[GAParameter::$PRODUCTSKU->withValue(1)->getName()]);
        self::assertEquals("key", $req->getParameters()[GAParameter::$PRODUCTNAME->withValue(1)->getName()]);
        self::assertEquals("brand", $req->getParameters()[GAParameter::$PRODUCTBRAND->withValue(1)->getName()]);
        self::assertEquals("category", $req->getParameters()[GAParameter::$PRODUCTCATEGORY->withValue(1)->getName()]);
        self::assertEquals("variant", $req->getParameters()[GAParameter::$PRODUCTVARIANT->withValue(1)->getName()]);
        self::assertEquals(1, $req->getParameters()[GAParameter::$PRODUCTPOSITION->withValue(1)->getName()]);
        self::assertEquals("3.00", $req->getParameters()[GAParameter::$PRODUCTPRICE->withValue(1)->getName()]);
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
