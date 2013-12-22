<?php
namespace App\Model\Shipping;

class Fixed implements IMethod
{
    private $_price = 42;
    private $_code = 'fixed';

    public function getCode()
    {
        return $this->_code;
    }

    public function getPrice()
    {
        return $this->_price;
    }
}