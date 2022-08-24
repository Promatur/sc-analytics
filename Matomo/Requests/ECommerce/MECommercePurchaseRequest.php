<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;


use ScAnalytics\Core\Transaction;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MECommercePurchaseRequest. Used to track a completed transaction. This class does not track extra items in a transaction, but does track their influence on the total price.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @copyright All Rights Reserved.
 */
class MECommercePurchaseRequest extends MECommerceRequest
{

    /**
     * MECommercePurchaseRequest constructor.
     * @param Transaction $transaction The completed transaction
     */
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction->getTotal(), $transaction->getSubTotal(), $transaction->getTaxes(), $transaction->getShipping(), $transaction->getDiscounts(), $transaction->getProducts());
        $this->setParameter(MParameter::$ORDERID, $transaction->getId());
    }

}