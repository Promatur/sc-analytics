<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;

use Money\Currency;
use Money\Money;
use ScAnalytics\Core\ECommerce\Product;

/**
 * Class MECommerceCartAddRequest. Sent, when adding one or more products to a shopping cart.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://matomo.org/docs/ecommerce-analytics/#tracking-add-to-cart-items-added-to-the-cart-optional
 */
class MECommerceCartUpdateRequest extends MECommerceRequest
{

    /**
     * GAECommerceCartAddRequest constructor.
     * @param Product[] $totalCart All products in the cart after adding the new products
     */
    public function __construct(array $totalCart)
    {
        $total = new Money(0, new Currency("EUR"));
        foreach ($totalCart as $product) {
            $add = $product->getFinalPrice() ?? $product->getPrice();
            if (!is_null($add)) {
                $total = $total->add($add);
            }
        }
        parent::__construct($total, null, null, null, null, $totalCart);
    }

}