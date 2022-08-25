<?php

namespace Matomo\Requests\ECommerce;

use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Product;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\ECommerce\MECommerceCheckoutStepRequest;
use PHPUnit\Framework\TestCase;
use ScAnalytics\Matomo\Requests\MPageViewRequest;
use ScAnalytics\Matomo\Requests\MRequest;

/**
 * Tests the MECommerceCheckoutStepRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MECommerceCheckoutStepRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $GLOBALS['start_time'] = microtime(true);
        $pageView = new MECommerceCheckoutStepRequest(null, [new Product("1")], 2, "PayPal");
        self::assertNotEmpty(self::get($pageView, "pageViewID"));
        self::assertNotEmpty($pageView->getParameters()[MParameter::$ACTION->getName()]);
        self::assertArrayHasKey(MParameter::$GENERATIONTIME->getName(), $pageView->getParameters());

        self::assertEquals("checkout", $pageView->getParameters()[MParameter::$EVENTCATEGORY->getName()]);
        self::assertEquals("Step 2", $pageView->getParameters()[MParameter::$EVENTACTION->getName()]);
        self::assertEquals("PayPal", $pageView->getParameters()[MParameter::$EVENTLABEL->getName()]);
        self::assertEquals(1, $pageView->getParameters()[MParameter::$EVENTVALUE->getName()]);
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param MPageViewRequest $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     * @noinspection PhpSameParameterValueInspection
     */
    private static function get(MPageViewRequest $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(MRequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
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
