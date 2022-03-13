<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Tests the GAEventRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAEventRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();

        $req = new GAEventRequest(true, "Category", "action", "label", 2);
        self::assertEquals("0", $req->getParameters()[GAParameter::$NONINTERACTION->getName()]);
        self::assertEquals("event", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Category", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("action", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);
        self::assertEquals("label", $req->getParameters()[GAParameter::$EVENTLABEL->getName()]);
        self::assertEquals(2, $req->getParameters()[GAParameter::$EVENTVALUE->getName()]);
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
