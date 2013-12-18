<?php
namespace App\Model;

class Region extends Entity
{
    public function getRegion()
    {
        return $this->_getData('region');
    }
}