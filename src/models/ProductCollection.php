<?php
require_once 'Product.php';
require_once 'EntityCollection.php';
require_once 'Resource/IResourceCollection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return array_map(
            function($data){
                return new Product($data);
            },$this->_resource->fetch());
    }
}