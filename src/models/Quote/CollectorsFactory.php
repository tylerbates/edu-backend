<?php
namespace App\Model\Quote;

use App\Model\Product;
use App\Model\Shipping\Factory;

class CollectorsFactory
{
    private $_prototype;
    private $_shippingFactory;

    public function __construct(Product $prototype, Factory $factory)
    {
        $this->_prototype = $prototype;
        $this->_shippingFactory =$factory;
    }

    public function getCollectors()
    {
        $subtotalCollector = new SubtotalCollector($this->_prototype);
        $shippingCollector = new ShippingCollector($this->_shippingFactory);
        return [
            'subtotal'=>$subtotalCollector,
            'shipping'=>$shippingCollector,
            'grand_total'=>new GrandTotalCollector($subtotalCollector,$shippingCollector)
        ];
    }
} 