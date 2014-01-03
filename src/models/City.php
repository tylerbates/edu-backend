<?php
namespace App\Model;

class City extends Entity
{
    public function getCity()
    {
        return $this->_getData('name');
    }
}