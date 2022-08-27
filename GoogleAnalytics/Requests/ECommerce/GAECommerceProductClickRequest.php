<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Class GAECommerceProductClickRequest. Measures a click on a product.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide#measuring-actions
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/enhanced-ecommerce#action-types
 */
class GAECommerceProductClickRequest extends GAEventRequest
{

    /**
     * GAECommerceProductClickRequest constructor.
     * @param string $listName The list, where the product is displayed
     * @param Product $product The product, which the user clicked on
     * @param int $productPosition The position of the product in the list
     */
    public function __construct(string $listName, Product $product, int $productPosition = 1)
    {
        parent::__construct(true, "UX", "click");
        $this->setParameter(GAParameter::$PRODUCTACTION, 'click');
        $this->setParameter(GAParameter::$CURRENCY, AnalyticsConfig::$currency);
        $this->setParameter(GAParameter::$PRODUCTACTIONLIST, $listName);

        $this->setParameter(GAParameter::$PRODUCTSKU->withValue(1), $product->getId());
        $this->setParameter(GAParameter::$PRODUCTNAME->withValue(1), $product->getKey());
        $this->setParameter(GAParameter::$PRODUCTBRAND->withValue(1), $product->getBrand());
        if (!is_null($product->getCategory())) {
            $this->setParameter(GAParameter::$PRODUCTCATEGORY->withValue(1), $product->getCategory());
        }
        if (!is_null($product->getVariant())) {
            $this->setParameter(GAParameter::$PRODUCTVARIANT->withValue(1), $product->getVariant());
        }
        $this->setParameter(GAParameter::$PRODUCTPOSITION->withValue(1), $productPosition);
        $this->setParameter(GAParameter::$PRODUCTPRICE->withValue(1), HelperFunctions::functional($product->getPrice()));
    }
}