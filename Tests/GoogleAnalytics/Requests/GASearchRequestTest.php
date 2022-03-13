<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GASearchRequest;

/**
 * Tests the GASearchRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GASearchRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new GASearchRequest(null, "promatur", 24, "companies");

        self::assertEquals("pageview", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Search", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("promatur", $req->getParameters()[GAParameter::$EVENTLABEL->getName()]);
        self::assertEquals("24", $req->getParameters()[GAParameter::$EVENTVALUE->getName()]);
        self::assertEquals("companies", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);
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
