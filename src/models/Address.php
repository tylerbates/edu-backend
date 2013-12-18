<?php
namespace App\Model;

class Address extends Entity
{
    public function getCity()
    {
        return $this->_getData('city');
    }

    public function getRegion()
    {
        return $this->_getData('region');
    }

    public function getMailIndex()
    {
        return $this->_getData('mail_index');
    }

    public function getStreet()
    {
        return $this->_getData('street');
    }

    public function getFlat()
    {
        return $this->_getData('flat');
    }
}