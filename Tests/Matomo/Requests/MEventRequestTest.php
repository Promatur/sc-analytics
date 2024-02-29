<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MEventRequest;

/**
 * Tests the MEventRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MEventRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();

        $req = new MEventRequest("Category", "action", "label", 2);
        self::assertEquals("Category/action", $req->getParameters()[MParameter::$ACTION->getName()]);
        self::assertEquals("Category", $req->getParameters()[MParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("action", $req->getParameters()[MParameter::$EVENTACTION->getName()]);
        self::assertEquals("label", $req->getParameters()[MParameter::$EVENTLABEL->getName()]);
        self::assertEquals(2, $req->getParameters()[MParameter::$EVENTVALUE->getName()]);
        self::assertTrue((bool)$req->getParameters()[MParameter::$CUSTOMACTION->getName()]);
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
