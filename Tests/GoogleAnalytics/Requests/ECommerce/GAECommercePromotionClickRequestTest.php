<?php

namespace GoogleAnalytics\Requests\ECommerce;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Promotion;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommercePromotionClickRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GAECommercePromotionClickRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommercePromotionClickRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();

        $req = new GAECommercePromotionClickRequest(new Promotion("id", "name", "creative", "position"));
        self::assertEquals("0", $req->getParameters()[GAParameter::$NONINTERACTION->getName()]);
        self::assertEquals("event", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Internal Promotions", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("click", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);
        self::assertEquals("name", $req->getParameters()[GAParameter::$EVENTLABEL->getName()]);

        self::assertEquals("click", $req->getParameters()[GAParameter::$PROMOACTION->getName()]);
        self::assertEquals("id", $req->getParameters()[GAParameter::$PROMOID->getName()]);
        self::assertEquals("name", $req->getParameters()[GAParameter::$PROMONAME->getName()]);
        self::assertEquals("creative", $req->getParameters()[GAParameter::$PROMOCREATIVE->getName()]);
        self::assertEquals("position", $req->getParameters()[GAParameter::$PROMOPOSITION->getName()]);
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
