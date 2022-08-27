<?php

namespace ScAnalytics\Core\ECommerce;

use Money\Money;
use ScAnalytics\Core\AnalyticsConfig;

/**
 * Class Transaction. A transaction is the purchase of one or multiple products by a user.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class Transaction
{

    /**
     * @var string A unique transaction id
     */
    private $id;

    /**
     * @var Product[] A list of products involved in the transaction
     */
    private $products;

    /**
     * @var Money The shipping costs of the transaction
     */
    private $shipping;

    /**
     * @var Money The taxes of the transaction
     */
    private $taxes;

    /**
     * @var Money The total amount of discounts applied to the transaction
     */
    private $discounts;

    /**
     * @var Money The total price of the transaction
     */
    private $total;

    /**
     * @var Money The subtotal of the transaction
     */
    private $subTotal;

    /**
     * @var string|null Affiliation or store name of a transaction
     */
    private $affiliation;

    /**
     * @var string|null A coupon code used for the transaction
     */
    private $coupon;

    /**
     * @var string|null The user id of the user who performed the transaction
     */
    private $user;

    /**
     * @var string The currency of the transaction. Defaults to <code>AnalyticsConfig::$currency</code>
     */
    private $currency;

    /**
     * @param string $id A unique transaction id
     * @param Product[] $products A list of products involved in the transaction
     * @param Money $shipping The shipping costs of the transaction
     * @param Money $taxes The taxes of the transaction
     * @param Money $discounts The total amount of discounts applied to the transaction
     * @param Money $total The total price of the transaction
     * @param Money $subTotal The subtotal of the transaction
     * @param string|null $affiliation Affiliation or store name of a transaction
     * @param string|null $coupon A coupon code used for the transaction
     * @param string|null $user A user id of the user who made the transaction
     * @param string|null $currency The currency of the transaction
     */
    public function __construct(string $id, array $products, Money $shipping, Money $taxes, Money $discounts, Money $total, Money $subTotal, ?string $affiliation = null, ?string $coupon = null, ?string $user = null, ?string $currency = null)
    {
        $this->id = $id;
        $this->products = $products;
        $this->shipping = $shipping;
        $this->taxes = $taxes;
        $this->discounts = $discounts;
        $this->total = $total;
        $this->subTotal = $subTotal;
        $this->affiliation = $affiliation;
        $this->coupon = $coupon;
        $this->user = $user;
        $this->currency = empty($currency) ? AnalyticsConfig::$currency : $currency;
    }

    /**
     * @return string A unique transaction id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Product[] A list of products involved in the transaction
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return Money The shipping costs of the transaction
     */
    public function getShipping(): Money
    {
        return $this->shipping;
    }

    /**
     * @return Money The taxes of the transaction
     */
    public function getTaxes(): Money
    {
        return $this->taxes;
    }

    /**
     * @return Money The total amount of discounts applied to the transaction
     */
    public function getDiscounts(): Money
    {
        return $this->discounts;
    }

    /**
     * @return Money The total price of the transaction
     */
    public function getTotal(): Money
    {
        return $this->total;
    }

    /**
     * @return Money The subtotal of the transaction
     */
    public function getSubTotal(): Money
    {
        return $this->subTotal;
    }

    /**
     * @return string|null Affiliation or store name of a transaction
     */
    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    /**
     * @return string|null A coupon code used for the transaction
     */
    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

    /**
     * @return string|null The user id of the user who performed the transaction
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @return string The currency of the transaction. Defaults to <code>AnalyticsConfig::$currency</code>
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}