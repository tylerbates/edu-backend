<?php
namespace App\Model\Payment;

use App\Model\Address;
use App\Model\Resource\IResourceEntity;

class Courier implements IMethod
{
    private $_code = 'courier';
    private $_label = 'payment to courier';
    private $_resource;
    private $_address;

    public function __construct(IResourceEntity $resource, Address $address)
    {
        $this->_resource = $resource;
        $this->_address = $address;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function isAvaliable()
    {
        return (bool) $this->_resource->find(['city'=>$this->_address->getCity()])['courier'];
    }

    public function getLabel()
    {
        return $this->_label;
    }

}