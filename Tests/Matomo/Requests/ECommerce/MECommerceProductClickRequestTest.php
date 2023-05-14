<?php

namespace Matomo\Requests\ECommerce;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\ECommerce\MECommerceProductClickRequest;

/**
 * Tests the MECommerceRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MECommerceProductClickRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new MECommerceProductClickRequest('list', new Product('id', null, null, 'key'));

        self::assertEquals("list", $req->getParameters()[MParameter::$CONTENTNAME->getName()]);
        self::assertEquals("key", $req->getParameters()[MParameter::$CONTENTPIECE->getName()]);
        self::assertEquals("click", $req->getParameters()[MParameter::$CONTENTINTERACTION->getName()]);
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
