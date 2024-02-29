<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MExceptionRequest;

/**
 * Tests the MExceptionRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MExceptionRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();

        $req = new MExceptionRequest("Error 5013", true);
        self::assertTrue((bool)$req->getParameters()[MParameter::$CUSTOMACTION->getName()]);
        self::assertEquals("Error 5013", $req->getParameters()[MParameter::$ERRORMESSAGE->getName()]);
        self::assertEquals("Fatal", $req->getParameters()[MParameter::$ERRORTYPE->getName()]);

        $req = new MExceptionRequest("Error 5014", false);
        self::assertTrue((bool)$req->getParameters()[MParameter::$CUSTOMACTION->getName()]);
        self::assertEquals("Error 5014", $req->getParameters()[MParameter::$ERRORMESSAGE->getName()]);
        self::assertEquals("Non-fatal", $req->getParameters()[MParameter::$ERRORTYPE->getName()]);

        $req = new MExceptionRequest("Error 5015");
        self::assertTrue((bool)$req->getParameters()[MParameter::$CUSTOMACTION->getName()]);
        self::assertEquals("Error 5015", $req->getParameters()[MParameter::$ERRORMESSAGE->getName()]);
        self::assertEquals("Non-fatal", $req->getParameters()[MParameter::$ERRORTYPE->getName()]);
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
