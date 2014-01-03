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

    public function setData($data)
    {
        isset($this->_data['address_id']) ? $id = $this->_data['address_id'] : $id = 0;
        $this->_data = $data;
        $this->_data['address_id'] = $id;
    }
}