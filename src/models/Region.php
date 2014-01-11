<?php
namespace App\Model;

class Region extends Entity
{
    public function getRegion()
    {
        return $this->_getData('name');
    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function getId()
    {
        return $this->_getData('region_id');
    }
}