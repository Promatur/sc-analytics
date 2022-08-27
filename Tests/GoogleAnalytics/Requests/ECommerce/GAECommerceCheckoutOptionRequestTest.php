<?php

namespace GoogleAnalytics\Requests\ECommerce;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCheckoutOptionRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GAECommerceCheckoutOptionRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommerceCheckoutOptionRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new GAECommerceCheckoutOptionRequest(2, "PayPal");

        self::assertEquals("0", $req->getParameters()[GAParameter::$NONINTERACTION->getName()]);
        self::assertEquals("event", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Checkout", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("option", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);

        self::assertEquals("checkout_option", $req->getParameters()[GAParameter::$PRODUCTACTION->getName()]);
        self::assertEquals(2, $req->getParameters()[GAParameter::$CHECKOUTSTEP->getName()]);
        self::assertEquals("PayPal", $req->getParameters()[GAParameter::$CHECKOUTSTEPOPTION->getName()]);
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
