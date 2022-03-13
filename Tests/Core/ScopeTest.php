<?php

namespace ScAnalytics\Tests\Core;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Core\Scope;

/**
 * Tests the Scope class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class ScopeTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function test__construct(): void
    {
        $scope = new Scope();
        self::assertNull(self::get($scope, "language"));
        self::assertIsArray(self::get($scope, "customDimensions"));
        self::assertEmpty(self::get($scope, "customDimensions"));
        self::assertFalse(self::get($scope, "analyticsConsent"));
        self::assertNull(self::get($scope, "clientId"));
        self::assertNull(self::get($scope, "userId"));
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param Scope $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(Scope $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(Scope::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * @throws ReflectionException
     */
    public function testSetCustomDimension(): void
    {
        $scope = new Scope();
        self::assertIsArray(self::get($scope, "customDimensions"));
        self::assertEmpty(self::get($scope, "customDimensions"));

        $scope->setCustomDimension(4, "bread");
        self::assertEquals([4 => "bread"], self::get($scope, "customDimensions"));

        $scope->setCustomDimension(2, "banana");
        self::assertEquals([2 => "banana", 4 => "bread"], self::get($scope, "customDimensions"));

        $scope->setCustomDimension(4, null);
        self::assertEquals([2 => "banana"], self::get($scope, "customDimensions"));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetClientId(): void
    {
        $scope = new Scope();
        $scope->setClientId("04cc6376-9f18-11ec-b909-0242ac120002");
        self::assertEquals("04cc6376-9f18-11ec-b909-0242ac120002", self::get($scope, "clientId"));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetUserId(): void
    {
        $scope = new Scope();
        $scope->setUserId("482");
        self::assertEquals("482", self::get($scope, "userId"));
    }

    /**
     * @throws ReflectionException
     */
    public function testHasAnalyticsConsent(): void
    {
        $scope = new Scope();
        self::set($scope, "analyticsConsent", true);
        self::assertTrue($scope->hasAnalyticsConsent());

        self::set($scope, "analyticsConsent", false);
        self::assertFalse($scope->hasAnalyticsConsent());
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param Scope $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(Scope $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(Scope::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetLanguage(): void
    {
        $scope = new Scope();
        self::set($scope, "language", "de-de");
        self::assertEquals("de-de", $scope->getLanguage());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetCustomDimensions(): void
    {
        $scope = new Scope();
        self::set($scope, "customDimensions", [1 => "bread", 2 => "banana"]);
        self::assertEquals([1 => "bread", 2 => "banana"], $scope->getCustomDimensions());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetClientId(): void
    {
        $scope = new Scope();
        self::set($scope, "clientId", "569aff1e-9f18-11ec-b909-0242ac120002");
        self::assertEquals("569aff1e-9f18-11ec-b909-0242ac120002", $scope->getClientId());

        self::set($scope, "clientId", null);
        $clientId = $scope->getClientId();
        self::assertNotEmpty($clientId);
        self::assertNotNull($clientId);
        self::assertMatchesRegularExpression("/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/", $clientId ?? "");
    }

    /**
     * @throws ReflectionException
     */
    public function testGetUserID(): void
    {
        $scope = new Scope();
        self::set($scope, "userId", "482");
        self::assertEquals("482", $scope->getUserId());
    }

    /**
     * @throws ReflectionException
     */
    public function testSetLanguage(): void
    {
        $scope = new Scope();
        $scope->setLanguage("de-de");
        self::assertEquals("de-de", self::get($scope, "language"));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetAnalyticsConsent(): void
    {
        $scope = new Scope();
        $scope->setAnalyticsConsent(true);
        self::assertTrue(self::get($scope, "analyticsConsent"));

        $scope->setAnalyticsConsent(false);
        self::assertFalse(self::get($scope, "analyticsConsent"));
    }
}
