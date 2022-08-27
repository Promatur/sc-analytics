<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\PageData;
use ScAnalytics\Core\Promotion;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAPageViewRequest;

/**
 * Class GAECommercePromotionImpressionRequest.
 * Tracks promotions shown on a page.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see GoogleAnalytics::load()
 */
class GAECommercePromotionImpressionRequest extends GAPageViewRequest
{

    /**
     * GAECommerceImpressionRequest constructor.
     * @param PageData|null $pageData The data of the page
     * @param Promotion[] $promotions A list containing different promotions on the page
     */
    public function __construct(?PageData $pageData, array $promotions)
    {
        parent::__construct($pageData);
        $counter = 1;
        foreach ($promotions as $promotion) {
            $this->setParameter(GAParameter::$PROMOID->withValue($counter), $promotion->getId());
            $this->setParameter(GAParameter::$PROMONAME->withValue($counter), $promotion->getName());
            $this->setParameter(GAParameter::$PROMOCREATIVE->withValue($counter), $promotion->getCreative());
            $this->setParameter(GAParameter::$PROMOPOSITION->withValue($counter), $promotion->getPosition());
            $counter++;
        }
    }

}