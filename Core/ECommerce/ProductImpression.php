<?php

namespace ScAnalytics\Core\ECommerce;

use Money\Money;

/**
 * Class ProductImpression. Represents information about a product that has been viewed.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class ProductImpression
{

    /**
     * @var int The position of the product in the list
     */
    private $position;

    /**
     * @var Product The product that has been viewed
     */
    private $product;

    /**
     * @var array<int, string> A product-level custom dimension
     */
    private $dimensions;

    /**
     * @var array<int, int> A product-level custom metric
     */
    private $metrics;

    /**
     * @param int $position The position of the product in the list
     * @param Product $product The product that has been viewed
     * @param array<int, string> $dimensions A product-level custom dimension
     * @param array<int, int> $metrics A product-level custom metric
     */
    public function __construct(int $position, Product $product, array $dimensions = [], array $metrics = [])
    {
        $this->position = $position;
        $this->product = $product;
        $this->dimensions = $dimensions;
        $this->metrics = $metrics;
    }

    /**
     * @return int The position of the product in the list
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return Product The product that has been viewed
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return array<int, string> A product-level custom dimension
     */
    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    /**
     * @return array<int, int> The product-level custom metric
     */
    public function getMetrics(): array
    {
        return $this->metrics;
    }

}