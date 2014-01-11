<?php
namespace App\Model\Management;

use App\Model\Entity;

class ShippingPrice extends Entity
{
    public function setData($data)
    {
        $this->_data = $data;
    }

    public function add($data)
    {
        if($data['city'] == $this->getCity())
        {
            $this->_data['price'] = $data['price'];
        } else $this->_data = $data;
        $this->_data['pbd'] = 1;
        $this->save();
    }

    public function getCity()
    {
        return $this->getData('city');
    }

    public function getPrice()
    {
        return $this->getData('price');
    }

    public function delete()
    {
        $this->_resource->delete($this->_data['rate_id']);
    }
} 