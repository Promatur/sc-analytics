<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MSocialRequest;

/**
 * Tests the MSocialRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MSocialRequestTest extends TestCase
{

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

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        self::set("analytics", null);
        self::set("analyticsList", []);
        self::set("scope", new Scope());
    }

    public function test__construct(): void
    {
        Analytics::init();

        $req = new MSocialRequest("Twitter", "tweet", "https://promatur.com");
        self::assertEquals("Social Media", $req->getParameters()[MParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("Twitter (tweet)", $req->getParameters()[MParameter::$EVENTACTION->getName()]);
        self::assertEquals("https://promatur.com", $req->getParameters()[MParameter::$EVENTLABEL->getName()]);
    }
}
