<?php

namespace NoAnalytics;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\AParameter;
use ScAnalytics\Core\ARequest;
use ScAnalytics\NoAnalytics\NoRequest;

/**
 * Tests the NoRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see NoRequest Tested class
 */
class NoRequestTest extends TestCase
{

    /**
     * Helper function accessing properties using reflection.
     *
     * @param NoRequest $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(NoRequest $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(ARequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param NoRequest $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(NoRequest $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(ARequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    public function testSend(): void
    {
        $req = new NoRequest();
        self::assertTrue($req->send());
    }

    public function testUpdateGenerationTime(): void
    {
        $req = new NoRequest();
        $this->expectNotToPerformAssertions();
        $req->updateGenerationTime();
    }

    public function testSetUserIdentifier(): void
    {
        $req = new NoRequest();
        $this->expectNotToPerformAssertions();
        $req->setUserIdentifier("1");
        $req->setUserIdentifier("abc");
        $req->setUserIdentifier("");
        $req->setUserIdentifier(null);
    }

    public function testSetUser(): void
    {
        $req = new NoRequest();
        $this->expectNotToPerformAssertions();
        $req->setUser(1);
        $req->setUser(-1);
        $req->setUser(null);
    }

    /**
     * @throws ReflectionException
     * @throws \JsonException
     */
    public function testSetParameter(): void
    {
        $param = new class extends AParameter {
            public function __construct()
            {
                parent::__construct("test");
            }
        };
        $req = new NoRequest();
        self::assertEmpty(self::get($req, "parameters"));
        $req->setParameter(new $param(), "b");
        self::assertEmpty(self::get($req, "parameters"));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetDebug(): void
    {
        $req = new NoRequest();
        self::assertFalse(self::get($req, "debug"));
        $req->setDebug(true);
        self::assertTrue(self::get($req, "debug"));
    }

    /**
     * @throws ReflectionException
     */
    public function testIsDebug(): void
    {
        $req = new NoRequest();
        self::assertFalse($req->isDebug());
        $req->setDebug(true);
        self::set($req, "debug", true);
        self::assertTrue($req->isDebug());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetParameters(): void
    {
        $param = new class extends AParameter {
            public function __construct()
            {
                parent::__construct("test");
            }
        };
        $array = [new $param(), "b"];
        $req = new NoRequest();
        self::assertEmpty($req->getParameters());
        self::set($req, "parameters", $array);
        self::assertEquals($array, $req->getParameters());
    }
}
