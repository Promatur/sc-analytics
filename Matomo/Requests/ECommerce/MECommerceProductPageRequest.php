<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;


use JsonException;
use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MPageViewRequest;

/**
 * Class MECommerceProductPageRequest. Measures the view of a product page.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MECommerceProductPageRequest extends MPageViewRequest
{

    /**
     * MECommerceProductPageRequest constructor.
     * @param Product $product The product, which is viewed
     * @param PageData|null $pageData The data of the viewed page
     */
    public function __construct(Product $product, ?PageData $pageData = null)
    {
        parent::__construct($pageData);
        try {
            $this->setParameter(MParameter::$PRODUCT_CATEGORY, $product->getCategory());
            $this->setParameter(MParameter::$PRODUCT_PRICE, HelperFunctions::functional($product->getPrice()));
            $this->setParameter(MParameter::$PRODUCT_SKU, $product->getKey());
            $this->setParameter(MParameter::$PRODUCT_NAME, $product->getName());
        } catch (JsonException $e) {
            if (function_exists('\Sentry\configureScope')) {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($product): void {
                    $scope->setLevel(\Sentry\Severity::error());
                    $scope->setExtra('Product', $product);
                    \Sentry\captureMessage("Error adding variable to an ECommerceProductPageRequest.");
                });
            }
        }
    }

}
