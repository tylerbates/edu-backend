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

    public function getIterator()
    {
        return new \ArrayIterator($this->getCities());
    }
}