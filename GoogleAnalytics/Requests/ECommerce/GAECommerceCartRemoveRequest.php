<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Class GAECommerceCartRemoveRequest. Sent, when removing one or more products from a shopping cart.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide#combining-impressions-and-actions
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/enhanced-ecommerce#action-types
 */
class GAECommerceCartRemoveRequest extends GAEventRequest
{

    /**
     * GAECommerceCartRemoveRequest constructor.
     * @param Product[] $products A list of products, which are removed from the cart. Keys are their position starting with <code>0</code>
     */
    public function __construct(array $products)
    {
        parent::__construct(true, "UX", "remove_from_cart", null, count($products));
        $this->setParameter(GAParameter::$PRODUCTACTION, 'remove');
        $this->setParameter(GAParameter::$CURRENCY, AnalyticsConfig::$currency);

        foreach ($products as $index => $product) {
            $position = $index + 1;
            $this->setParameter(GAParameter::$PRODUCTSKU->withValue($position), $product->getId());
            $this->setParameter(GAParameter::$PRODUCTNAME->withValue($position), $product->getKey());
            $this->setParameter(GAParameter::$PRODUCTBRAND->withValue($position), $product->getBrand());
            if (!is_null($product->getCategory())) {
                $this->setParameter(GAParameter::$PRODUCTCATEGORY->withValue($position), $product->getCategory());
            }
            if (!is_null($product->getVariant())) {
                $this->setParameter(GAParameter::$PRODUCTVARIANT->withValue($position), $product->getVariant());
            }
            $this->setParameter(GAParameter::$PRODUCTPOSITION->withValue($position), $position);
            $this->setParameter(GAParameter::$PRODUCTPRICE->withValue($position), HelperFunctions::functional($product->getPrice()));
            $this->setParameter(GAParameter::$PRODUCTQUANTITY->withValue($position), $product->getQuantity());
            if (!is_null($product->getCoupon())) {
                $this->setParameter(GAParameter::$PRODUCTCOUPON->withValue($position), $product->getCoupon());
            }
        }
    }
}