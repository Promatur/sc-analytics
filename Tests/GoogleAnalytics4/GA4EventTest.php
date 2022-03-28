<?php

namespace GoogleAnalytics4;

use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\GoogleAnalytics4\GA4Event;
use ScAnalytics\GoogleAnalytics4\GA4EventParameter;

/**
 * Tests the GA4Event class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GA4EventTest extends TestCase
{

    /**
     * Helper function accessing properties using reflection.
     *
     * @param GA4Event $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(GA4Event $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(GA4Event::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param GA4Event $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(GA4Event $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(GA4Event::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $event = new GA4Event("abc");
        self::assertEquals("abc", self::get($event, "name"));
        self::assertIsArray(self::get($event, "parameters"));
        self::assertEmpty(self::get($event, "parameters"));
    }

    /**
     * @throws ReflectionException
     * @throws JsonException
     */
    public function testSetParameters()
    {
        $event = new GA4Event("abc");
        $event->setParameter(new GA4EventParameter("test"), true);
        self::assertEquals(["test" => '1'], self::get($event, "parameters"));

        $event->setParameter(new GA4EventParameter("test2"), "abc");
        self::assertEquals(["test" => '1', "test2" => "abc"], self::get($event, "parameters"));

        $event->setParameter(new GA4EventParameter("test"), null);
        self::assertEquals(["test2" => "abc"], self::get($event, "parameters"));
    }

    /**
     * @throws ReflectionException
     * @throws JsonException
     */
    public function testJsonSerialize(): void
    {
        $event = new GA4Event("abc");
        self::set($event, "parameters", ["test" => '1', "test2" => "abc", "test3" => '{"a":"b"}']);
        $json = json_encode($event, JSON_THROW_ON_ERROR);
        self::assertEquals('{"name":"abc","parameters":{"test":"1","test2":"abc","test3":"{\"a\":\"b\"}"}}', $json);
    }
}
