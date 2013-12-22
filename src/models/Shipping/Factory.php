<?php
namespace App\Model\Shipping;

use App\Model\Address;

class Factory
{
    private $_address;

    public function __construct(Address $address)
    {
        $this->_address = $address;
    }

    public function getMethods()
    {
        return [
            new Fixed($this->_address),
            new TableRate($this->_address)
        ];
    }
}