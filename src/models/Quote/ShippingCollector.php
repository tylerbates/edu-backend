<?php
namespace App\Model\Quote;

use App\Model\Quote;
use App\Model\Shipping\Factory;

class ShippingCollector implements ICollector
{
    private $_shippingFactory;

    public function __construct(Factory $factory)
    {
        $this->_shippingFactory = $factory;
    }

    public function collect(Quote $quote)
    {
        $shipping = 0;
        $this->_shippingFactory->setAddress($quote->getAddress());
        foreach($this->_shippingFactory->getMethods() as $method)
        {
            if($method->getCode() == $quote->getShippingCode())
                $shipping = $method->getPrice();
        }
        return $shipping;
    }
} 