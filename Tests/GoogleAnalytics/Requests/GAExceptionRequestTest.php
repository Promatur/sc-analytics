<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAExceptionRequest;

/**
 * Tests the GAExceptionRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAExceptionRequestTest extends TestCase
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

        $req = new GAExceptionRequest("Error 5013", true);
        self::assertEquals("Error 5013", $req->getParameters()[GAParameter::$EXCEPTIONDESCRIPTION->getName()]);
        self::assertEquals("1", $req->getParameters()[GAParameter::$EXCEPTIONFATAL->getName()]);

        $req = new GAExceptionRequest("Error 5012", false);
        self::assertEquals("Error 5012", $req->getParameters()[GAParameter::$EXCEPTIONDESCRIPTION->getName()]);
        self::assertEquals("0", $req->getParameters()[GAParameter::$EXCEPTIONFATAL->getName()]);

        $req = new GAExceptionRequest("Error 5011");
        self::assertEquals("Error 5011", $req->getParameters()[GAParameter::$EXCEPTIONDESCRIPTION->getName()]);
        self::assertEquals("0", $req->getParameters()[GAParameter::$EXCEPTIONFATAL->getName()]);
    }

}
