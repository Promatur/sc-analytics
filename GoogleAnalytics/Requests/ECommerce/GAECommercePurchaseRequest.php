<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\ECommerce\Transaction;
use ScAnalytics\Core\HelperFunctions;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Class GAECommercePurchaseRequest. Used to track a completed transaction. This class does not track extra items in a transaction, but does track their influence on the total price. Can only track the first transaction coupon code.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommercePurchaseRequest extends GAEventRequest
{

    /**
     * GAECommercePurchaseRequest constructor.
     * @param Transaction $transaction The completed transaction
     */
    public function __construct(Transaction $transaction)
    {
        parent::__construct(true, "Ecommerce", "purchase", null, count($transaction->getProducts()));
        $this->setParameter(GAParameter::$PRODUCTACTION, 'purchase');
        $this->setParameter(GAParameter::$CURRENCY, $transaction->getCurrency());
        $this->setParameter(GAParameter::$TRANSACTIONID, $transaction->getId());
        $this->setParameter(GAParameter::$TRANSACTIONAFFILIATION, $transaction->getAffiliation());
        $this->setParameter(GAParameter::$TRANSACTIONREVENUE, HelperFunctions::functional($transaction->getTotal()));
        $this->setParameter(GAParameter::$TRANSACTIONTAX, HelperFunctions::functional($transaction->getTaxes()));
        $this->setParameter(GAParameter::$TRANSACTIONSHIPPING, HelperFunctions::functional($transaction->getShipping()));
        $this->setParameter(GAParameter::$TRANSACTIONCOUPON, $transaction->getCoupon());
        if (!is_null($transaction->getUser())) {
            $this->setParameter(GAParameter::$USERID, $transaction->getUser());
        }

        foreach ($transaction->getProducts() as $index => $product) {
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