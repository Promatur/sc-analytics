<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\Promotion;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Class GAECommercePromotionClickRequest.
 * Measures a click on a promotion.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommercePromotionClickRequest extends GAEventRequest
{

    /**
     * GAECommercePromotionClickRequest constructor.
     * @param Promotion $promotion The promotion that was clicked
     */
    public function __construct(Promotion $promotion)
    {
        parent::__construct(true, "Internal Promotions", "click", $promotion->getName() ?? $promotion->getId());
        $this->setParameter(GAParameter::$PROMOACTION, "click");
        $this->setParameter(GAParameter::$PROMOID, $promotion->getId());
        $this->setParameter(GAParameter::$PROMONAME, $promotion->getName());
        $this->setParameter(GAParameter::$PROMOCREATIVE, $promotion->getCreative());
        $this->setParameter(GAParameter::$PROMOPOSITION, $promotion->getPosition());
    }
}