<?php
require_once 'Product.php';
require_once 'EntityCollection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return $this->_getEntities();
    }
}