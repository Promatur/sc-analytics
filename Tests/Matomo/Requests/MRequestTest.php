<?php

namespace ScAnalytics\Tests\Matomo\Requests;

use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\Scope;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MRequest;

class MRequestTest extends TestCase
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

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        AnalyticsConfig::$debug = false;
        AnalyticsConfig::$matomoID = "";
        self::setAnalytics("analytics", null);
        self::setAnalytics("analyticsList", []);
        self::setAnalytics("scope", new Scope());
        self::set(null, "pageViewID", null);
        unset($GLOBALS['start_time']);
    }

    /**
     * Helper function accessing properties using reflection.
     *
     * @param MRequest|null $instance The instance to get the value from
     * @param string $field Name of the field
     * @return mixed The contents of the field
     * @throws ReflectionException
     */
    private static function get(?MRequest $instance, string $field)
    {
        $apiDataClass = new ReflectionClass(MRequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        return $prop->getValue($instance);
    }

    /**
     * Helper function setting properties using reflection.
     *
     * @param MRequest|null $instance The instance to set the value for
     * @param string $field Name of the field
     * @param mixed $value Value to set
     * @throws ReflectionException
     */
    private static function set(?MRequest $instance, string $field, $value): void
    {
        $apiDataClass = new ReflectionClass(MRequest::class);
        $prop = $apiDataClass->getProperty($field);
        $prop->setAccessible(true);
        $prop->setValue($instance, $value);
    }

    public function test__construct(): void
    {
        AnalyticsConfig::$matomoID = "2";
        Analytics::init();
        $req = new MRequest();
        // Check for mandatory parameters
        self::assertEquals("2", $req->getParameters()[MParameter::$SITEID->getName()]);
        self::assertEquals("1", $req->getParameters()[MParameter::$REC->getName()]);
    }

    /**
     * @throws JsonException
     * @throws ReflectionException
     */
    public function testAddCustomVariable(): void
    {
        Analytics::init();
        $req = new MRequest();

        $req->addCustomVariable("key", "value");
        self::assertEquals([["key", "value"]], self::get($req, "customVariables"));

        $req->addCustomVariable("key", "value2");
        self::assertEquals([["key", "value"], ["key", "value2"]], self::get($req, "customVariables"));

        self::set($req, "customVariables", []);
        $req->addCustomVariable("key", 2);
        self::assertEquals([["key", "2"]], self::get($req, "customVariables"));

        self::set($req, "customVariables", []);
        $req->addCustomVariable("key", false);
        self::assertEquals([["key", "0"]], self::get($req, "customVariables"));

        self::set($req, "customVariables", []);
        $req->addCustomVariable("key", ["a" => "b"]);
        self::assertEquals([["key", '{"a":"b"}']], self::get($req, "customVariables"));

        self::set($req, "customVariables", []);
        $req->addCustomVariable("key", true);
        self::assertEquals([["key", "1"]], self::get($req, "customVariables"));
    }

    public function testUpdateGenerationTime(): void
    {
        Analytics::init();
        $req = new MRequest();
        self::assertArrayNotHasKey(MParameter::$GENERATIONTIME->getName(), $req->getParameters());
        $req->updateGenerationTime();
        self::assertArrayNotHasKey(MParameter::$GENERATIONTIME->getName(), $req->getParameters());

        $GLOBALS['start_time'] = microtime(true);
        $req->updateGenerationTime();
        self::assertArrayHasKey(MParameter::$GENERATIONTIME->getName(), $req->getParameters());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPageViewID(): void
    {
        self::assertNull(MRequest::getPageViewID());
        self::set(null, "pageViewID", "abc");
        self::assertEquals("abc", MRequest::getPageViewID());
    }

    public function testSetPageTitle(): void
    {
        Analytics::init();
        $req = new MRequest();
        $req->setPageTitle("test");
        self::assertEquals("test", $req->getParameters()[MParameter::$ACTION->getName()]);

        $req->setPageTitle("");
        self::assertEquals("", $req->getParameters()[MParameter::$ACTION->getName()]);

        $req->setPageTitle("test", ["parent"]);
        self::assertEquals("parent/test", $req->getParameters()[MParameter::$ACTION->getName()]);

        $req->setPageTitle("test", ["parent", "parent2"]);
        self::assertEquals("parent/parent2/test", $req->getParameters()[MParameter::$ACTION->getName()]);
    }

    /**
     * @throws ReflectionException
     */
    public function testGeneratePageViewID(): void
    {
        for ($i = 0; $i < 50; $i++) {
            MRequest::generatePageViewID();
            /** @var string $pageViewId */
            $pageViewId =  self::get(null, "pageViewID");
            self::assertIsString($pageViewId);
            self::assertEquals(6, strlen($pageViewId));
        }
    }

    public function testSetUserIdentifier(): void
    {
        Analytics::init();
        $req = new MRequest();

        $req->setUserIdentifier("a1");
        self::assertEquals("a1", $req->getParameters()[MParameter::$USERID->getName()]);

        $req->setUserIdentifier(null);
        self::assertArrayNotHasKey(MParameter::$USERID->getName(), $req->getParameters());
    }
}
