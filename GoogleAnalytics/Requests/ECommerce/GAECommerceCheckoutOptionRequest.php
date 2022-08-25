<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Class GAECommerceCheckoutOptionRequest. Send additional information about a checkout step, after the step was initiated.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see GAECommerceCheckoutStepRequest Sending the complete request with products
 */
class GAECommerceCheckoutOptionRequest extends GAEventRequest
{

    /**
     * GAECommerceCheckoutOptionRequest constructor.
     * @param int $step The step number
     * @param string|null $option Additional information about a checkout step
     */
    public function __construct(int $step, ?string $option = null)
    {
        parent::__construct(true, "Checkout", "option");
        $this->setParameter(GAParameter::$PRODUCTACTION, 'checkout_option');
        $this->setParameter(GAParameter::$CHECKOUTSTEP, $step);
        $this->setParameter(GAParameter::$CHECKOUTSTEPOPTION, $option);
    }
}