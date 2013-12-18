<?php
namespace App\Model;

class Entity
{
    protected  $_data = array();
    protected  $_resource;

    public function __construct(array $data, Resource\IResourceEntity $resource = null)
    {
        $this->_data = $data;
        $this->_resource = $resource;
    }

    protected  function _getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    public function getData($key)
    {
        return $this->_getData($key);
    }

    public function load($id, $pr_key)
    {
        $this->_data = $this->_resource->find([$pr_key=>$id]);
    }

    public function save()
    {
        $this->_resource->save($this->_data);
    }
}