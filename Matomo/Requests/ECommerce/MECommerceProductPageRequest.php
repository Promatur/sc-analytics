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
        $variables = array();
        if (!is_null($product->getCategory())) {
            $variables[5] = array("_pkc", $product->getCategory());
        }
        $variables[2] = array("_pkp", HelperFunctions::functional($product->getPrice()));
        $variables[3] = array("_pks", $product->getKey());
        $variables[4] = array("_pkn", $product->getName());
        try {
            $this->setParameter(MParameter::$PAGEVARIABLES, $variables);
        } catch (JsonException $e) {
            if (function_exists('\Sentry\configureScope')) {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($variables): void {
                    $scope->setLevel(\Sentry\Severity::error());
                    $scope->setExtra('Array', print_r($variables, true));
                    \Sentry\captureMessage("Error adding variable to an ECommerceProductPageRequest.");
                });
            }
        }
    }

}