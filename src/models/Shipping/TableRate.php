<?php
namespace App\Model\Shipping;

use App\Model\Address;
use App\Model\Resource\IResourceEntity;

class TableRate implements IMethod
{
    private $_resource;
    private $_address;
    private $_price;
    private $_code = 'table_rate';
    private $_label = 'price depends on address';

    public function __construct(IResourceEntity $resource, Address $address)
    {
        $this->_resource = $resource;
        $this->_address = $address;
        $this->_price = $this->_assignPrice();
    }

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
        return $this->_label . ' (' . $this->_address->getCity() . '): ';
    }

    private function _assignPrice()
    {
        return $this->_resource->find(['city'=>$this->_address->getCity()])['price'];
    }
}