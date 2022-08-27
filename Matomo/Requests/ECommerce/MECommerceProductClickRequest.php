<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;


use ScAnalytics\Core\ECommerce\Product;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MRequest;

/**
 * Class MECommerceProductClickRequest. Measures a click on a product.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @link https://developer.matomo.org/api-reference/tracking-api#optional-content-tracking-info API Documentation
 * @link https://matomo.org/docs/content-tracking/ Content tracking
 */
class MECommerceProductClickRequest extends MRequest
{

    /**
     * MECommerceProductClickRequest constructor.
     * @param string $listName The list, where the product is displayed
     * @param Product $product The product, which the user clicked on
     */
    public function __construct(string $listName, Product $product)
    {
        parent::__construct();
        $this->setParameter(MParameter::$CONTENTNAME, $listName);
        $this->setParameter(MParameter::$CONTENTPIECE, $product->getKey());
        $this->setParameter(MParameter::$CONTENTINTERACTION, 'click');
    }

}