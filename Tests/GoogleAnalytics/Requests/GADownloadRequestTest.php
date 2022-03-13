<?php

namespace ScAnalytics\Tests\GoogleAnalytics\Requests;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Scope;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GADownloadRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GADownloadRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GADownloadRequestTest extends TestCase
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

        $req = new GADownloadRequest("file.txt", 20);
        self::assertEquals("Download", $req->getParameters()[GAParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("download", $req->getParameters()[GAParameter::$EVENTACTION->getName()]);
        self::assertEquals("file.txt", $req->getParameters()[GAParameter::$EVENTLABEL->getName()]);
        self::assertEquals(20, $req->getParameters()[GAParameter::$EVENTVALUE->getName()]);
    }
}
