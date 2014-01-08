<?php
namespace App\Model;

class Admin extends Entity
{
    public function logIn($login,$password)
    {
        $this->load($login,'name');
        return $this->_validatePassword($password);
    }

    private function _validatePassword($password)
    {
        return md5($password) == $this->_getData('password');
    }

    public function getName()
    {
        return $this->_getData('name');
    }
} 