<?php

namespace ScAnalytics\Core;

use Money\Money;

/**
 * Class Transaction. A transaction is the purchase of one or multiple products by a user.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
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
     * @param string $id A unique transaction id
     * @param Product[] $products A list of products involved in the transaction
     * @param Money $shipping The shipping costs of the transaction
     * @param Money $taxes The taxes of the transaction
     * @param Money $discounts The total amount of discounts applied to the transaction
     * @param Money $total The total price of the transaction
     * @param Money $subTotal The subtotal of the transaction
     * @param string|null $affiliation Affiliation or store name of a transaction
     * @param string|null $coupon A coupon code used for the transaction
     */
    public function __construct(string $id, array $products, Money $shipping, Money $taxes, Money $discounts, Money $total, Money $subTotal, ?string $affiliation = null, ?string $coupon = null)
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
}