<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Product;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;

/**
 * Class GAECommerceProductPageRequest. Measures the view of a product page.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommerceProductPageRequest extends GAPageViewRequest
{

    /**
     * GAECommerceProductPageRequest constructor.
     * @param Product $product The product, which is viewed
     * @param PageData|null $pageData The data of the viewed page
     */
    public function __construct(Product $product, ?PageData $pageData = null)
    {
        parent::__construct($pageData);
        $this->setParameter(GAParameter::$PRODUCTACTION, 'detail');
        $this->setParameter(GAParameter::$CURRENCY, AnalyticsConfig::$currency);
        $position = 1;
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
    }

}