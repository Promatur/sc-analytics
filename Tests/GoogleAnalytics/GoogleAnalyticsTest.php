<?php

namespace ScAnalytics\Tests\GoogleAnalytics;

use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ScAnalytics\Analytics;
use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Product;
use ScAnalytics\Core\Scope;
use ScAnalytics\Core\Transaction;
use ScAnalytics\GoogleAnalytics\GoogleAnalytics;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCartAddRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCartRemoveRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceCheckoutStepRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceProductClickRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommerceProductPageRequest;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommercePurchaseRequest;
use ScAnalytics\GoogleAnalytics\Requests\GADownloadRequest;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;
use ScAnalytics\GoogleAnalytics\Requests\GAExceptionRequest;
use ScAnalytics\GoogleAnalytics\Requests\GALogoutRequest;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;
use ScAnalytics\GoogleAnalytics\Requests\GASearchRequest;
use ScAnalytics\GoogleAnalytics\Requests\GASocialRequest;
use ScAnalytics\GoogleAnalytics\Requests\GATimingRequest;

/**
 * Tests the Google Analytics class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GoogleAnalyticsTest extends TestCase
{

    public function testGetName(): void
    {
        $ga = new GoogleAnalytics();
        self::assertEquals("Google Analytics", $ga->getName());
    }

    public function testIsAvailable(): void
    {
        $ga = new GoogleAnalytics();

        AnalyticsConfig::$googleAnalyticsIDs = [];
        self::assertFalse($ga->isAvailable());

        AnalyticsConfig::$googleAnalyticsIDs = ["UA-XXXXXX-X"];
        self::assertTrue($ga->isAvailable());
    }

    public function testLoadJS(): void
    {
        $ga = new GoogleAnalytics();
        $pageData = new PageData("title");

        AnalyticsConfig::$googleAnalyticsIDs = [];
        self::assertEmpty($ga->loadJS($pageData));

        AnalyticsConfig::$googleAnalyticsIDs = ["UA-XXXXXX-X", "UA-000000-2"];

        $clientId = GoogleAnalytics::getClientId();
        $code = $ga->loadJS($pageData);
        self::assertStringContainsString('<script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXX-X">', $code);
        self::assertStringContainsString('<script src="', $code);
        self::assertStringContainsString('/ga.min.js?cb=', $code);
        self::assertStringContainsString('id="_ga"', $code);
        self::assertStringContainsString('data-keys="UA-XXXXXX-X;UA-000000-2"', $code);
        self::assertStringContainsString('data-consent="false"', $code);
        self::assertStringContainsString('data-clientid="' . $clientId . '"', $code);
        self::assertStringContainsString('defer', $code);
    }

    public function testGetClientID(): void
    {
        $clientId = GoogleAnalytics::getClientID();
        self::assertMatchesRegularExpression("/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/", $clientId);
        self::assertEquals($clientId, $_SESSION['ga_tempid']);

        self::assertEquals($clientId, GoogleAnalytics::getClientID());

        $_COOKIE['_gid'] = "abc";
        self::assertEquals("abc", GoogleAnalytics::getClientID());

        $_COOKIE['_ga'] = "GA1.3.895300000.1646700000";
        self::assertEquals("895300000.1646700000", GoogleAnalytics::getClientID());
    }

    public function testEvent(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAEventRequest::class, $ga->event(false, "category", "action"));
    }

    public function testException(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAExceptionRequest::class, $ga->exception());
    }

    public function testPageView(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAPageViewRequest::class, $ga->pageView(null));
    }

    public function testSocial(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GASocialRequest::class, $ga->social("Twitter", "tweet", "https://promatur.com"));
    }

    public function testTiming(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GATimingRequest::class, $ga->timing("Assets", "script.js", 13));
    }

    public function testSearch(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GASearchRequest::class, $ga->search(null, "promatur", 27));
    }

    public function testLogout(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GALogoutRequest::class, $ga->logout());
    }

    public function testDownload(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GADownloadRequest::class, $ga->download("image.jpg"));
    }

    public function testAddCart(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAECommerceCartAddRequest::class, $ga->addCart([]));
    }

    public function testRemoveCart(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAECommerceCartRemoveRequest::class, $ga->removeCart([]));
    }

    public function testPurchase(): void
    {
        $ga = new GoogleAnalytics();
        $m = new Money(100, new Currency("EUR"));
        self::assertInstanceOf(GAECommercePurchaseRequest::class, $ga->purchase(new Transaction("id", [new Product("p")], $m, $m, $m, $m, $m)));
    }

    public function testCheckoutStep(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAECommerceCheckoutStepRequest::class, $ga->checkoutStep(null, [], 1));
    }

    public function testProductClick(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAECommerceProductClickRequest::class, $ga->productClick("list", new Product("id")));
    }

    public function testProductPage(): void
    {
        $ga = new GoogleAnalytics();
        self::assertInstanceOf(GAECommerceProductPageRequest::class, $ga->productPage(new Product("id")));
    }

    protected function setUp(): void
    {
        AnalyticsConfig::$googleAnalyticsIDs = ["UA-XXXXXX-X"];
        Analytics::init();
        $_COOKIE = [];
        $_SESSION = [];
    }

    /**
     * @throws ReflectionException
     */
    protected function tearDown(): void
    {
        AnalyticsConfig::$googleAnalyticsIDs = [];
        self::setAnalytics("analytics", null);
        self::setAnalytics("analyticsList", []);
        self::setAnalytics("scope", new Scope());
        unset($_COOKIE["_ga"], $_COOKIE['_gid'], $_SESSION['ga_tempid']);
    }

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
}
