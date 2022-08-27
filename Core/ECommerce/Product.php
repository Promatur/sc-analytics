<?php

namespace ScAnalytics\Core\ECommerce;

use Money\Money;

/**
 * Class Product. Represents a product to be sold.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class Product
{

    /**
     * @var string ID or SKU
     */
    private $id;

    /**
     * @var string|null A unique key for the product
     */
    private $key;

    /**
     * @var string|null The name of the product
     */
    private $name;

    /**
     * @var string|null A category for the product
     */
    private $category;

    /**
     * @var string|null A variant for the product
     */
    private $variant;

    /**
     * @var string|null A brand for the product
     */
    private $brand;

    /**
     * @var Money|null The original price of the product
     */
    private $price;

    /**
     * @var Money|null A final price, after discounts and taxes
     */
    private $finalPrice;

    /**
     * @var int|null The quantity of the product in the cart or checkout process
     */
    private $quantity;

    /**
     * @var string|null A coupon code applied to the product
     */
    private $coupon;

    /**
     * @param string $id ID or SKU
     * @param Money|null $price The original price of the product
     * @param Money|null $finalPrice A final price, after discounts and taxes
     * @param string|null $key A unique key for the product
     * @param string|null $name The name of the product
     * @param string|null $category A category for the product
     * @param string|null $variant A variant for the product
     * @param string|null $brand A brand for the product
     * @param int|null $quantity The quantity of the product in the cart or checkout process
     * @param string|null $coupon A coupon code applied to the product
     */
    public function __construct(string $id, ?Money $price = null, ?Money $finalPrice = null, ?string $key = null, ?string $name = null, ?string $category = null, ?string $variant = null, ?string $brand = null, ?int $quantity = null, ?string $coupon = null)
    {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
        $this->category = $category;
        $this->variant = $variant;
        $this->brand = $brand;
        $this->price = $price;
        $this->finalPrice = $finalPrice;
        $this->quantity = $quantity;
        $this->coupon = $coupon;
    }


    /**
     * @return string ID or SKU
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null A unique key for the product
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return string|null The name of the product
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null A category for the product
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null A variant for the product
     */
    public function getVariant(): ?string
    {
        return $this->variant;
    }

    /**
     * @return string|null A brand for the product
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @return Money|null The original price of the product
     */
    public function getPrice(): ?Money
    {
        return $this->price;
    }

    /**
     * @return Money|null A final price, after discounts and taxes
     */
    public function getFinalPrice(): ?Money
    {
        return $this->finalPrice;
    }

    /**
     * @return int|null The quantity of the product in the cart or checkout process
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @return string|null A coupon code applied to the product
     */
    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

}