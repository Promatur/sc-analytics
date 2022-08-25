<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;


use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Product;
use ScAnalytics\Matomo\MParameter;
use ScAnalytics\Matomo\Requests\MPageViewRequest;

/**
 * Class MECommerceCheckoutStepRequest. Sent, starting or proceeding in a checkout process. Is sent as the initial page view request.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class MECommerceCheckoutStepRequest extends MPageViewRequest
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
        $this->setParameter(MParameter::$EVENTCATEGORY, "checkout");
        $this->setParameter(MParameter::$EVENTACTION, "Step $step");
        $this->setParameter(MParameter::$EVENTLABEL, $option);
        $this->setParameter(MParameter::$EVENTVALUE, count($products));
    }

}