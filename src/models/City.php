<?php
namespace App\Model;

class City extends Entity
{
    public function getCity()
    {
        return $this->_getData('name');
    }

    public function setData($data)
    {
        $this->_data = $data;
    }
}