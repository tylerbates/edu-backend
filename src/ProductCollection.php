<?php
require_once 'Product.php';

class ProductCollection
{
    public function __construct($data)
    {
        $this->_data = $data;
    }

    public function getProducts()
    {
        if(isset($this->_offset)){
            $offset_products = array_slice($this->_data,$this->_offset);
            return $offset_products;
        }
        return $this->_data;
    }

    public function getSize()
    {
        return isset($this->_limit) ? $this->_limit : count($this->_data);
    }

    public function limit($value)
    {
        $this->_limit = $value;
    }

    public function offset($value)
    {
        $this->_offset = $value;
    }

    private $_data = array();
    private $_limit;
    private $_offset;
}