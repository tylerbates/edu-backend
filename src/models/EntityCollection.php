<?php
namespace App\Model;

class EntityCollection implements \IteratorAggregate
{
    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
        $this->_setEntities();
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

    private $_entities = array();
    protected $_resource;
}