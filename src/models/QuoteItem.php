<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class QuoteItem extends Entity
{
    public function addQty($qty)
    {
        $this->_data['qty'] = $qty;
    }

    public function getQty()
    {
        return $this->_getData('qty');
    }

    public function updateQty($qty)
    {
        $this->_data['qty'] = $qty;
    }

    public function save(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['link_id'] = $id;
    }

    public function delete(IResourceEntity $resource)
    {
        $resource->delete($this->_data['link_id']);
    }

    public function getId()
    {
        return $this->_getData('link_id');
    }

    public function getProductId()
    {
        return $this->_getData('product_id');
    }
}