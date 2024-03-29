<?php


namespace ScAnalytics\Matomo\Requests\ECommerce;


use ScAnalytics\Core\ECommerce\Transaction;
use ScAnalytics\Matomo\MParameter;

/**
 * Class MECommercePurchaseRequest. Used to track a completed transaction. This class does not track extra items in a transaction, but does track their influence on the total price.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
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
        if (!empty($transaction->getUser())) {
            $this->setUserIdentifier($transaction->getUser());
        }
    }

}