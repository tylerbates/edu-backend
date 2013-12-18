<?php
namespace App\Model;

class CityCollection extends EntityCollection
{
    public function getCities()
    {
        return array_map(
            function($data){
                return new City($data);
            },$this->_resource->fetch()
        );
    }
}