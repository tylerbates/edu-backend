<?php
namespace App\Model;

class ProductCollection extends EntityCollection
{
    public function getProducts()
    {
        return array_map(
            function($data){
                return new Product($data);
            },$this->_resource->fetch());
    }
}