<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAScreenViewRequest;

/**
 * Tests the GAScreenViewRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAScreenViewRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new GAScreenViewRequest("Home");
        self::assertEquals("screenview", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Home", $req->getParameters()[GAParameter::$SCREENNAME->getName()]);
        self::assertArrayNotHasKey(GAParameter::$APPID->getName(), $req->getParameters());
        self::assertArrayNotHasKey(GAParameter::$APPINSTALLERID->getName(), $req->getParameters());

        $req = new GAScreenViewRequest("Home", "App-2", "4cs2");
        self::assertEquals("screenview", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Home", $req->getParameters()[GAParameter::$SCREENNAME->getName()]);
        self::assertEquals("App-2", $req->getParameters()[GAParameter::$APPID->getName()]);
        self::assertEquals("4cs2", $req->getParameters()[GAParameter::$APPINSTALLERID->getName()]);

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
