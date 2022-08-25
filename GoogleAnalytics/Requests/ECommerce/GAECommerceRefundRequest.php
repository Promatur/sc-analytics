<?php


namespace ScAnalytics\GoogleAnalytics\Requests\ECommerce;


use ScAnalytics\Core\Product;
use ScAnalytics\Core\Transaction;
use ScAnalytics\GoogleAnalytics\GAParameter;
use ScAnalytics\GoogleAnalytics\Requests\GAEventRequest;

/**
 * Class GAECommerceRefundRequest. Used to track the full or partial refund of a transaction.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class GAECommerceRefundRequest extends GAEventRequest
{

    /**
     * GAECommerceRefundRequest constructor.
     * @param Transaction $transaction The transaction to refund
     * @param Product[] $products The products to refund. Leave empty to refund the whole transaction
     */
    public function __construct(Transaction $transaction, array $products = [])
    {
        parent::__construct(false, "Ecommerce", "refund", null, count($products));
        $this->setParameter(GAParameter::$PRODUCTACTION, 'refund');
        $this->setParameter(GAParameter::$TRANSACTIONID, $transaction->getId());

        foreach ($products as $index => $product) {
            $position = $index + 1;
            $this->setParameter(GAParameter::$PRODUCTSKU->withValue($position), $product->getId());
            $this->setParameter(GAParameter::$PRODUCTQUANTITY->withValue($position), $product->getQuantity());
        }
    }
}