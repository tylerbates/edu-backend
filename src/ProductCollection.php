<?php
require_once 'Product.php';

class ProductCollection
{
    public function __construct(array $data)
    {
        $this->_data = $data;
        $this->_limit = count($this->_data);
        $this->_offset = 0;
    }

    public function getProducts()
    {
            return array_slice($this->_data,$this->_offset,$this->_limit);
    }

    public function getSize()
    {
        return count($this->getProducts());
    }

    public function limit($value)
    {
        $this->_limit = $value;
    }

    public function offset($value)
    {
        $this->_offset = $value;
    }

    private $_data;
    private $_limit;
    private $_offset;
}