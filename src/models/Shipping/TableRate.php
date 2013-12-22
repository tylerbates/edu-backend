<?php
namespace App\Model\Shipping;

class TableRate implements IMethod
{
    private $_price;
    private $_code = 'table_rate';

    public function getCode()
    {
        return $this->_code;
    }

    public function getPrice()
    {
        return $this->_price;
    }
}