<?php

namespace GoogleAnalytics\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use ScAnalytics\Analytics;
use ScAnalytics\Core\Product;
use ScAnalytics\Core\Promotion;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\ECommerce\GAECommercePromotionImpressionRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests the GAECommercePromotionImpressionRequest class.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommercePromotionImpressionRequestTest extends TestCase
{

    public function test__construct(): void
    {
        Analytics::init();
        $req = new GAECommercePromotionImpressionRequest(null, [new Promotion("id", "name", "creative", "position"), new Promotion("id2"), new Promotion(null, "name3")]);

        self::assertEquals("pageview", $req->getParameters()[GAParameter::$TYPE->getName()]);

        self::assertEquals("id", $req->getParameters()[GAParameter::$PROMOID->withValue(1)->getName()]);
        self::assertEquals("name", $req->getParameters()[GAParameter::$PROMONAME->withValue(1)->getName()]);
        self::assertEquals("creative", $req->getParameters()[GAParameter::$PROMOCREATIVE->withValue(1)->getName()]);
        self::assertEquals("position", $req->getParameters()[GAParameter::$PROMOPOSITION->withValue(1)->getName()]);

        self::assertEquals("id2", $req->getParameters()[GAParameter::$PROMOID->withValue(2)->getName()]);

        self::assertEquals("name3", $req->getParameters()[GAParameter::$PROMONAME->withValue(3)->getName()]);
    }
}
