<?php
namespace App\Model;
use App\Model\Resource\IResourceCollection;
use App\Model\Resource\IResourceEntity;

class Basket extends Entity
{
    public function getId()
    {
        return $this->_getData('basket_id');
    }

    public function create(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['basket_id'] = $id;
    }
}