<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;


use JsonException;
use Money\Money;
use ScAnalytics\Analytics;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\Product;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MRequest;

/**
 * Class MECommerceRequest. A generic ECommerce request for Matomo.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @copyright All Rights Reserved.
 */
class MECommerceRequest extends MRequest
{

    /**
     * MECommerceRequest constructor.
     * @param Money $grandTotal Total price of an ECommerce order
     * @param Money|null $subTotal Sub total excluding shipping
     * @param Money|null $tax Tax amount of the order
     * @param Money|null $shipping Shipping amount of the order
     * @param Money|null $discount Discount amount of the order
     * @param Product[] $products Products in the order
     */
    public function __construct(Money $grandTotal, ?Money $subTotal = null, ?Money $tax = null, ?Money $shipping = null, ?Money $discount = null, array $products = array())
    {
        parent::__construct();
        $this->setParameter(MParameter::$CONVERSIONGOAL, 0);
        $this->setParameter(MParameter::$REVENUE, HelperFunctions::functional($grandTotal));
        if (!is_null($subTotal)) {
            $this->setParameter(MParameter::$SUBTOTAL, HelperFunctions::functional($subTotal));
        }
        if (!is_null($tax)) {
            $this->setParameter(MParameter::$TAX, HelperFunctions::functional($tax));
        }
        if (!is_null($shipping)) {
            $this->setParameter(MParameter::$SHIPPING, HelperFunctions::functional($shipping));
        }
        if (!is_null($discount)) {
            $this->setParameter(MParameter::$DISCOUNT, HelperFunctions::functional($discount));
        }
        $this->setParameter(MParameter::$LASTORDERTIMESTAMP, Analytics::getScope()->getLastOrder());
        $items = array();
        foreach ($products as $product) {
            $items[] = array($product->getId(), $product->getKey(), $product->getCategory(), HelperFunctions::functional($product->getFinalPrice()), $product->getQuantity());
        }
        try {
            $this->setParameter(MParameter::$ECITEMS, $items);
        } catch (JsonException $e) {
            if (function_exists('\Sentry\configureScope')) {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($items): void {
                    $scope->setLevel(\Sentry\Severity::error());
                    $scope->setExtra('Items', print_r($items, true));
                    \Sentry\captureMessage("Error adding products to an ECommerceRequest.");
                });
            }
        }
    }
}