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
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommercePurchaseRequest;

/**
 * Tests the GAECommercePurchaseRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommercePurchaseRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $m = new Money(400, new Currency("EUR"));
        $tx = new Transaction("txid",[new Product("id", new Money(300, new Currency("EUR")), new Money(250, new Currency("EUR")), "key", "name", "category", "variant", "brand", 2, "coupon")], $m->multiply(1.5), $m->multiply(1.7), $m->multiply(1.9), $m->multiply(2.1), $m->multiply(2.3), "affiliation", "Coupon", "user", "EUR");
        $req = new GAECommercePurchaseRequest($tx);

        self::assertEquals("0", $req->getParameters()[GAParameter::$NONINTERACTION->getName()]);
        self::assertEquals("event", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Ecommerce", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("purchase", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);
        self::assertEquals(1, $req->getParameters()[GAParameter::$EVENTVALUE->getName()]);

        self::assertEquals("purchase", $req->getParameters()[GAParameter::$PRODUCTACTION->getName()]);
        self::assertEquals("EUR", $req->getParameters()[GAParameter::$CURRENCY->getName()]);
        self::assertEquals("txid", $req->getParameters()[GAParameter::$TRANSACTIONID->getName()]);
        self::assertEquals("affiliation", $req->getParameters()[GAParameter::$TRANSACTIONAFFILIATION->getName()]);
        self::assertEquals("8.40", $req->getParameters()[GAParameter::$TRANSACTIONREVENUE->getName()]);
        self::assertEquals("6.80", $req->getParameters()[GAParameter::$TRANSACTIONTAX->getName()]);
        self::assertEquals("6.00", $req->getParameters()[GAParameter::$TRANSACTIONSHIPPING->getName()]);
        self::assertEquals("Coupon", $req->getParameters()[GAParameter::$TRANSACTIONCOUPON->getName()]);

        self::assertEquals("user", $req->getParameters()[GAParameter::$USERID->getName()]);

        self::assertEquals("id", $req->getParameters()[GAParameter::$PRODUCTSKU->withValue(1)->getName()]);
        self::assertEquals("key", $req->getParameters()[GAParameter::$PRODUCTNAME->withValue(1)->getName()]);
        self::assertEquals("brand", $req->getParameters()[GAParameter::$PRODUCTBRAND->withValue(1)->getName()]);
        self::assertEquals("category", $req->getParameters()[GAParameter::$PRODUCTCATEGORY->withValue(1)->getName()]);
        self::assertEquals("variant", $req->getParameters()[GAParameter::$PRODUCTVARIANT->withValue(1)->getName()]);
        self::assertEquals(1, $req->getParameters()[GAParameter::$PRODUCTPOSITION->withValue(1)->getName()]);
        self::assertEquals("3.00", $req->getParameters()[GAParameter::$PRODUCTPRICE->withValue(1)->getName()]);
        self::assertEquals(2, $req->getParameters()[GAParameter::$PRODUCTQUANTITY->withValue(1)->getName()]);
        self::assertEquals("coupon", $req->getParameters()[GAParameter::$PRODUCTCOUPON->withValue(1)->getName()]);
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
