<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GASocialRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GASocialRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GASocialRequestTest extends TestCase
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

        $req = new GASocialRequest("Twitter", "tweet", "https://promatur.com");
        self::assertEquals("social", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertEquals("Twitter", $req->getParameters()[GAParameter::$SOCIALNETWORK->getName()]);
        self::assertEquals("tweet", $req->getParameters()[GAParameter::$SOCIALACTION->getName()]);
        self::assertEquals("https://promatur.com", $req->getParameters()[GAParameter::$SOCIALTARGET->getName()]);
    }

}
