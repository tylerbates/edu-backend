<?php
namespace App\Model\Payment;

use App\Model\Address;
use App\Model\Resource\IResourceEntity;

class Factory
{
    private $_collection;
    private $_resource;
    private $_address;

    public function __construct(IResourceEntity $resource = null, Address $address = null, Collection $collection)
    {
        $this->_address = $address;
        $this->_resource = $resource;
        $this->_collection = $collection;
    }

    public function getMethods()
    {
        foreach($this->_getMethods() as $method)
        {
            $this->_collection->addPayment($method);
        }
        return $this->_collection;
    }

    private function _getMethods()
    {
        return [
            new Courier($this->_resource, $this->_address),
            new CashOnDelivery($this->_resource, $this->_address)
        ];
    }
}