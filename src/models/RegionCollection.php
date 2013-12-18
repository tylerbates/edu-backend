<?php
namespace App\Model;

class RegionCollection extends EntityCollection
{
    public function getRegions()
    {
        return array_map(
            function($data){
                return new Region($data);
            },$this->_resource->fetch()
        );
    }
}