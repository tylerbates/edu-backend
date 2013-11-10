<?php
require_once 'Entity.php';

class Collection implements IteratorAggregate
{
    public function __construct($data)
    {
        $this->_entities = $data;
        $this->_limit = count($this->_entities);
        $this->_offset = 0;
    }

    protected function _getEntities()
    {
        $entities = array_slice($this->_entities,$this->_offset,$this->_limit);
        return $this->_sortEntities($entities);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->_getEntities());
    }

    private function _sortEntities($entities)
    {
        if(!$this->_sortField) return $entities;

        foreach($entities as $item)
        {
            $fields[] = $item->getData($this->_sortField);
        }
        array_multisort($fields,$entities);
        return $entities;
    }

    public function getSize()
    {
        return count($this->_getEntities());
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
        $this->_sortField = $field;
    }

    private $_entities = array();
    private $_limit;
    private $_offset;
    private $_sortField;
}