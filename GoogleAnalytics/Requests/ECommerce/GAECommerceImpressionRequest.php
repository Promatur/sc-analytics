<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\ECommerce\ProductImpression;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;

/**
 * Class GAECommerceImpressionRequest.
 * Represents information about a product that has been viewed. Is sent as the initial page view request.
 * @package PromaturAPI\Analytics\GoogleAnalyticsAPI\Requests\ECommerce
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @copyright All Rights Reserved.
 * @see GoogleAnalytics::load()
 * @link https://developers.google.com/analytics/devguides/collection/gtagjs/enhanced-ecommerce#impression-data
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#il_nm
 */
class GAECommerceImpressionRequest extends GAPageViewRequest
{

    /**
     * GAECommerceImpressionRequest constructor.
     * @param PageData|null $pageData The data of the page
     * @param array<string, array<ProductImpression>> $lists A list containing the list of products that have been viewed
     */
    public function __construct(?PageData $pageData, array $lists)
    {
        parent::__construct($pageData);
        $this->setParameter(GAParameter::$CURRENCY, AnalyticsConfig::$currency);

        $listPosition = 1;
        foreach ($lists as $listName => $impressions) {
            $this->setParameter(GAParameter::$PRODUCTIMPRESSIONLIST->withValue($listPosition), $listName);
            foreach ($impressions as $impression) {
                $position = $impression->getPosition();
                $product = $impression->getProduct();
                // Product
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONSKU->withValue($listPosition)->withValue($position), $product->getId());
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONNAME->withValue($listPosition)->withValue($position), $product->getName());
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONBRAND->withValue($listPosition)->withValue($position), $product->getBrand());
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONCATEGORY->withValue($listPosition)->withValue($position), $product->getCategory());
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONVARIANT->withValue($listPosition)->withValue($position), $product->getVariant());
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONPOSITION->withValue($listPosition)->withValue($position), $position);
                $this->setParameter(GAParameter::$PRODUCTIMPRESSIONPRICE->withValue($listPosition)->withValue($position), HelperFunctions::functional($product->getPrice()));
                // Dimensions
                foreach ($impression->getDimensions() as $dimension => $value) {
                    $this->setParameter(GAParameter::$PRODUCTIMPRESSIONCUSTOMDIMENSION->withValue($listPosition)->withValue($position)->withValue($dimension), $value);
                }
                foreach ($impression->getMetrics() as $metric => $value) {
                    if (is_numeric($value)) {
                        $this->setParameter(GAParameter::$PRODUCTIMPRESSIONCUSTOMMETRIC->withValue($listPosition)->withValue($position)->withValue($metric), $value);
                    }
                }
            }
            $listPosition++;
        }
    }

}