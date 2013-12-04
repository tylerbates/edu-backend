<?php
namespace App\Model;

class EntityCollection implements \IteratorAggregate
{
    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
        $this->_setEntities();
        $this->_limit = count($this->_entities);
        $this->_offset = 0;
    }

    private function _setEntities()
    {
        return $this->_entities = $this->_resource->fetch();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_resource->fetch());
    }

    public function getSize()
    {
        return count($this->_resource->fetch());
    }

    public function limit($value)
    {
        $this->_limit = $value;
    }

    public function offset($value)
    {
        $this->_offset = $value;
    }

    private $_entities = array();
    private $_limit;
    private $_offset;
    protected $_resource;
}