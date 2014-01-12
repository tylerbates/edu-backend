<?php
namespace App\Model;

class Customer extends Entity
{
    public function getId()
    {
        return $this->_getData('customer_id');
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function getEmail()
    {
        return $this->_getData('email');
    }

    public function setData($data)
    {
        $this->_data = $data;
    }
}