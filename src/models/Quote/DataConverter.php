<?php
namespace App\Model\Quote;

use App\Model\Order;
use App\Model\Quote;

class DataConverter implements IConverter
{
    public function toOrder(Quote $quote, Order $order)
    {
        $order->setCustomerId((int)$quote->getCustomerId());
        $order->setShippingMethod($quote->getShippingCode());
        $order->setPaymentMethod($quote->getPaymentCode());
    }
}