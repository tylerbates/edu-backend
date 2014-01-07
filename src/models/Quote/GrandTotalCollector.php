<?php
namespace App\Model\Quote;


use App\Model\Quote;

class GrandTotalCollector implements ICollector
{
    private $_subtotal;
    private $_shipping;

    public function __construct(SubtotalCollector $stcollector, ShippingCollector $shcollector)
    {
        $this->_subtotal = $stcollector;
        $this->_shipping = $shcollector;
    }

    public function collect(Quote $quote)
    {
        return $this->_subtotal->collect($quote) + $this->_shipping->collect($quote);
    }
} 