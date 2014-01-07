<?php
namespace App\Model\Shipping;

use App\Model\Address;
use App\Model\Resource\IResourceEntity;

class Factory
{
    private $_address;
    private $_resource;

    public function __construct(IResourceEntity $resource = null, Address $address)
    {
        $this->_resource = $resource;
        $this->_address = $address;
    }

    public function getMethods()
    {
        return [
            new Fixed($this->_address),
            new TableRate($this->_resource,$this->_address)
        ];
    }

    public function setAddress(Address $address)
    {
        $this->_address = $address;
    }
}