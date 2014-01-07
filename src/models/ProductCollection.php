<?php
namespace App\Model;

use App\Model\Resource\IResourceCollection;

class ProductCollection extends EntityCollection
{
    private $_prototype;

    public function __construct(IResourceCollection $resource, Product $prototype)
    {
        $this->_prototype = $prototype;
        $this->_resource = $resource;
    }

    public function getProducts()
    {
        return array_map(
            function($data){
                $product = clone $this->_prototype;
                $product->setData($data);
                return $product;
            },$this->_resource->fetch());
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getProducts());
    }
}