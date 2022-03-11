<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MPerformanceRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the MPerformanceRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MPerformanceRequestTest extends TestCase
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
        $req = new MPerformanceRequest(null, 1, 2, 3, 4, 5, 6);

        self::assertNotEmpty($req->getParameters()[MParameter::$PAGEVIEWID->getName()]);
        self::assertEquals("1", $req->getParameters()[MParameter::$NETWORKTIME->getName()]);
        self::assertEquals("2", $req->getParameters()[MParameter::$SERVERTIME->getName()]);
        self::assertEquals("3", $req->getParameters()[MParameter::$TRANSFERTIME->getName()]);
        self::assertEquals("4", $req->getParameters()[MParameter::$DOMPROCESSINGTIME->getName()]);
        self::assertEquals("5", $req->getParameters()[MParameter::$DOMCOMPLETIONTIME->getName()]);
        self::assertEquals("6", $req->getParameters()[MParameter::$ONLOADTIME->getName()]);
    }
}
