<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GARequest;

/**
 * Tests the GARequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GARequestTest extends TestCase
{

    /**
     * Helper function setting properties using reflection.
     *
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function setAnalytics(string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Analytics::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($value);
    }

    protected function setUp(): void
    {
        AnalyticsConfig::$googleAnalyticsIDs = ["UA-XXXXXX-X"];
        Analytics::init();
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        AnalyticsConfig::$debug = false;
        AnalyticsConfig::$googleAnalyticsIDs = [];
        self::setAnalytics("analytics", null);
        self::setAnalytics("analyticsList", []);
        self::setAnalytics("scope", new Scope());
        unset($GLOBALS['start_time']);
    }

    public function test__construct(): void
    {
        $req = new GARequest();
        // Check for mandatory parameters
        self::assertNotEmpty($req->getParameters()[GAParameter::$VERSION->getName()]);
    }

    public function testSetType(): void
    {
        $values = ['pageview', 'screenview', 'event', 'transaction', 'item', 'social', 'exception', 'timing'];

        foreach ($values as $value) {
            $req = new GARequest();
            $req->setType($value);
            self::assertEquals($value, $req->getParameters()[GAParameter::$TYPE->getName()]);
        }
    }

    public function testUpdateGenerationTime(): void
    {
        $req = new GARequest();
        self::assertArrayNotHasKey(GAParameter::$LOADTIME->getName(), $req->getParameters());
        $req->updateGenerationTime();
        self::assertArrayNotHasKey(GAParameter::$LOADTIME->getName(), $req->getParameters());

        $GLOBALS['start_time'] = microtime(true);
        $req->updateGenerationTime();
        self::assertArrayHasKey(GAParameter::$LOADTIME->getName(), $req->getParameters());
    }

    public function testSetUserIdentifier(): void
    {
        $req = new GARequest();

        $req->setUserIdentifier("a1");
        self::assertEquals("a1", $req->getParameters()[GAParameter::$USERID->getName()]);

        $req->setUserIdentifier(null);
        self::assertArrayNotHasKey(GAParameter::$USERID->getName(), $req->getParameters());
    }

    public function testSetUser(): void
    {
        $req = new GARequest();

        $req->setUser(3);
        self::assertEquals(3, $req->getParameters()[GAParameter::$USERID->getName()]);

        $req->setUserIdentifier(null);
        self::assertArrayNotHasKey(GAParameter::$USERID->getName(), $req->getParameters());
    }
}
