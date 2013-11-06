<?php
require_once 'Product.php';
require_once 'Collection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return $this->getCollection();
    }
}