<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;

/**
 * Tests the GAPageViewRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAPageViewRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $GLOBALS['start_time'] = microtime(true);
        $req = new GAPageViewRequest();
        self::assertEquals("pageview", $req->getParameters()[GAParameter::$TYPE->getName()]);
        self::assertArrayNotHasKey(GAParameter::$DOCUMENTTITLE->getName(), $req->getParameters());
        self::assertArrayHasKey(GAParameter::$LOADTIME->getName(), $req->getParameters());

        $_GET['page'] = 'index';
        $req = new GAPageViewRequest();
        self::assertEquals("index", $req->getParameters()[GAParameter::$DOCUMENTTITLE->getName()]);

        $req = new GAPageViewRequest(new PageData("Title"));
        self::assertEquals("Title", $req->getParameters()[GAParameter::$DOCUMENTTITLE->getName()]);
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        self::set("analytics", null);
        self::set("analyticsList", []);
        self::set("scope", new Scope());
        unset($GLOBALS['start_time']);
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
