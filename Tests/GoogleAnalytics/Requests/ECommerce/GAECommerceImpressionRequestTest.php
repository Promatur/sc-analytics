<?php

namespace GoogleAnalytics\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\ECommerce\ProductImpression;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceImpressionRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GAECommerceImpressionRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommerceImpressionRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $m = new Money(300, new Currency("EUR"));
        $req = new GAECommerceImpressionRequest(null, ["Search Results" => [new ProductImpression(2, new Product("p1", $m, null, null, "name", "category", "variant", "brand"), [2 => "red", 5 => "M"], [2 => 5, 3 => 2])]]);

        self::assertEquals("pageview", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("USD", $req->getParameters()[GAParameter::$CURRENCY->getName()]);

        self::assertEquals("Search Results", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONLIST->withValue(1)->getName()]);
        // Product
        self::assertEquals("p1", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONSKU->withValue(1)->withValue(2)->getName()]);
        self::assertEquals("name", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONNAME->withValue(1)->withValue(2)->getName()]);
        self::assertEquals("brand", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONBRAND->withValue(1)->withValue(2)->getName()]);
        self::assertEquals("category", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONCATEGORY->withValue(1)->withValue(2)->getName()]);
        self::assertEquals("variant", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONVARIANT->withValue(1)->withValue(2)->getName()]);
        self::assertEquals(2, $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONPOSITION->withValue(1)->withValue(2)->getName()]);
        self::assertEquals("3.00", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONPRICE->withValue(1)->withValue(2)->getName()]);
        // Dimensions
        self::assertEquals("red", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONCUSTOMDIMENSION->withValue(1)->withValue(2)->withValue(2)->getName()]);
        self::assertEquals("M", $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONCUSTOMDIMENSION->withValue(1)->withValue(2)->withValue(5)->getName()]);
        // Metrics
        self::assertEquals(5, $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONCUSTOMMETRIC->withValue(1)->withValue(2)->withValue(2)->getName()]);
        self::assertEquals(2, $req->getParameters()[GAParameter::$PRODUCTIMPRESSIONCUSTOMMETRIC->withValue(1)->withValue(2)->withValue(3)->getName()]);

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
