<?php
namespace App\Model\Shipping;

class Fixed implements IMethod
{
    private $_price = 42;
    private $_code = 'fixed';
    private $_label = 'fixed price';

    public function getCode()
    {
        return $this->_code;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function getLabel()
    {
        return $this->_label;
    }
}