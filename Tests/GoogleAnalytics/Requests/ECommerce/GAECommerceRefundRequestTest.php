<?php

namespace GoogleAnalytics\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\ECommerce\Transaction;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceRefundRequest;

/**
 * Tests the GAECommerceRefundRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommerceRefundRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();

        $m = new Money(20, new Currency('EUR'));
        $req = new GAECommerceRefundRequest(new Transaction("id", [], $m, $m, $m, $m, $m), [new Product("pid", null, null, null, null, null, null, null, 2)]);

        self::assertEquals("1", $req->getParameters()[GAParameter::$NONINTERACTION->getName()]);
        self::assertEquals("event", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Ecommerce", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("refund", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);
        self::assertEquals(1, $req->getParameters()[GAParameter::$EVENTVALUE->getName()]);

        self::assertEquals("refund", $req->getParameters()[GAParameter::$PRODUCTACTION->getName()]);
        self::assertEquals("id", $req->getParameters()[GAParameter::$TRANSACTIONID->getName()]);
        self::assertEquals("pid", $req->getParameters()[GAParameter::$PRODUCTSKU->withValue(1)->getName()]);
        self::assertEquals(2, $req->getParameters()[GAParameter::$PRODUCTQUANTITY->withValue(1)->getName()]);
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
