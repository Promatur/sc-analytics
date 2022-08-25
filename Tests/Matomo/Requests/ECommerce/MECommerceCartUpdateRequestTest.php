<?php

namespace Matomo\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Product;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\ECommerce\MECommerceCartUpdateRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the MECommerceCartUpdateRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MECommerceCartUpdateRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new MECommerceCartUpdateRequest([
            new Product("1", new Money(100, new Currency("EUR"))),
            new Product("2", null, new Money(300, new Currency("EUR"))),
            new Product("3")
        ]);

        self::assertEquals(0, $req->getParameters()[MParameter::$CONVERSIONGOAL->getName()]);
        self::assertEquals("4.00", $req->getParameters()[MParameter::$REVENUE->getName()]);
        self::assertEquals('[["1",null,null,null,null],["2",null,null,"3.00",null],["3",null,null,null,null]]', $req->getParameters()[MParameter::$ECITEMS->getName()]);
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
