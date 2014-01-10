<?php
namespace App\Model\Management;

use App\Model\Resource\IResourceCollection;

class ShippingPriceCollection implements \IteratorAggregate
{
    private $_prototype;

    public function __construct(IResourceCollection $resource, ShippingPrice $prototype)
    {
        $this->_prototype = $prototype;
        $this->_resource = $resource;
    }

    public function getPrices()
    {
        return array_map(
            function($data){
                $shippingPrice = clone $this->_prototype;
                $shippingPrice->setData($data);
                return $shippingPrice;
            },$this->_resource->fetch());
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getPrices());
    }

    public function sort($field, $direction)
    {
        $this->_resource->sort($field,$direction);
    }

    public function filter($request, $columns)
    {
        $this->_resource->find($request,$columns);
    }
}