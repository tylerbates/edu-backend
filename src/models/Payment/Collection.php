<?php
namespace App\Model\Payment;

use App\Model\Address;

class Collection implements \IteratorAggregate
{
    private $_methods;

    public function addPayment(IMethod $payment)
    {
        $this->_methods[] = $payment;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_methods);
    }

    public function avaliable()
    {
        $methods = [];
        foreach($this->_methods as $method)
        {
            if($method->isAvaliable()) $methods[] = $method;
        }

        return $methods;
    }
}