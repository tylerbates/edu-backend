<?php
class Collection
{
    public function __construct($data)
    {
        $this->_data = $data;
        $this->_limit = count($this->_data);
        $this->_offset = 0;
    }

    public function getCollection()
    {
        return array_slice($this->_data,$this->_offset,$this->_limit);
    }

    public function getSize()
    {
        return count($this->getCollection());
    }

    public function limit($value)
    {
        $this->_limit = $value;
    }

    public function offset($value)
    {
        $this->_offset = $value;
    }

    public function sort($field)
    {
        foreach($this->_data as $item)
        {
            $fields[] = $item->_getData($field);
        }
        array_multisort($fields,$this->_data);
    }

    private $_data = array();
    private $_limit;
    private $_offset;
}