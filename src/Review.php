<?php

class Review
{
    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function getEmail()
    {
        return $this->_getData('email');
    }

    public function getText()
    {
        return $this->_getData('text');
    }

    public function getRating()
    {
        return $this->_getData('rating');
    }

    public function belongsToProduct($product_sku_reference)
    {
        return $this->_getData('product_sku_reference') == $product_sku_reference ? true : false;
    }

    public function _getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    private $_data = array();
}