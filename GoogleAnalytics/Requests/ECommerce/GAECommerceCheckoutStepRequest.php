<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;



use ScAnalytics\Core\AnalyticsConfig;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Product;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;

/**
 * Class GAECommerceCheckoutStepRequest. Sent, starting or proceeding in a checkout process. Is sent as the initial page view request.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see GoogleAnalytics::load() Include an instance of this class as page view
 * @see GAECommerceCheckoutOptionRequest If you want to add extra information after the page has loaded
 */
class GAECommerceCheckoutStepRequest extends GAPageViewRequest
{

    /**
     * GAECommerceCheckoutStepRequest constructor.
     * @param PageData|null $pageData The data of the page
     * @param Product[] $products A list of products, which are added to the cart. Keys are their position starting with <code>0</code>
     * @param int $step The step number
     * @param string|null $option Additional information about a checkout step
     */
    public function __construct(?PageData $pageData, array $products, int $step, ?string $option = null)
    {
        parent::__construct($pageData);
        $this->setParameter(GAParameter::$PRODUCTACTION, 'checkout');
        $this->setParameter(GAParameter::$CURRENCY, AnalyticsConfig::$currency);
        $this->setParameter(GAParameter::$CHECKOUTSTEP, $step);
        $this->setParameter(GAParameter::$CHECKOUTSTEPOPTION, $option);

        foreach ($products as $index => $product) {
            $position = $index + 1;
            $this->setParameter(GAParameter::$PRODUCTSKU->withValue($position), $product->getId());
            $this->setParameter(GAParameter::$PRODUCTNAME->withValue($position), $product->getKey());
            $this->setParameter(GAParameter::$PRODUCTBRAND->withValue($position), $product->getBrand());
            if (!is_null($product->getCategory())) {
                $this->setParameter(GAParameter::$PRODUCTCATEGORY->withValue($position), $product->getCategory());
            }
            if (!is_null($product->getVariant())) {
                $this->setParameter(GAParameter::$PRODUCTVARIANT->withValue($position), $product->getVariant());
            }
            $this->setParameter(GAParameter::$PRODUCTPOSITION->withValue($position), $position);
            $this->setParameter(GAParameter::$PRODUCTPRICE->withValue($position), HelperFunctions::functional($product->getPrice()));
            $this->setParameter(GAParameter::$PRODUCTQUANTITY->withValue($position), $product->getQuantity());
            if (!is_null($product->getCoupon())) {
                $this->setParameter(GAParameter::$PRODUCTCOUPON->withValue($position), $product->getCoupon());
            }
        }
    }
}