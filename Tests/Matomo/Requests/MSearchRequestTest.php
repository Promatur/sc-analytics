<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MSearchRequest;

/**
 * Tests the MSearchRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MSearchRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new MSearchRequest(null, "promatur", 24, "companies");

        self::assertNotEmpty($req->getParameters()[MParameter::$PAGEVIEWID->getName()]);
        self::assertEquals("promatur", $req->getParameters()[MParameter::$SEARCHKEYWORD->getName()]);
        self::assertEquals("24", $req->getParameters()[MParameter::$SEARCHCOUNT->getName()]);
        self::assertEquals("companies", $req->getParameters()[MParameter::$SEARCHCATEGORY->getName()]);
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
