<?php
namespace App\Model\Quote;

use App\Model\Order;
use App\Model\Quote;

class AddressConverter implements IConverter
{
    public function toOrder(Quote $quote, Order $order)
    {
        $address = $quote->getAddress();
        $order->setAddress(
            $address->getRegion() . ' ' .
            $address->getCity() . ' ' .
            $address->getMailIndex() . ' ' .
            $address->getStreet() . ' st. ' .
            $address->getFlat()
        );
    }
}