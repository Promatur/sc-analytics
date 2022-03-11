<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MTimingRequest;

/**
 * Tests the MLogoutRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MTimingRequestTest extends TestCase
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

        $req = new MTimingRequest("cURL", "loadImage", 24, "Google CDN");
        self::assertEquals("Timing - cURL", $req->getParameters()[MParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("loadImage", $req->getParameters()[MParameter::$EVENTACTION->getName()]);
        self::assertEquals("Google CDN", $req->getParameters()[MParameter::$EVENTLABEL->getName()]);
        self::assertEquals("24", $req->getParameters()[MParameter::$EVENTVALUE->getName()]);
    }
}
