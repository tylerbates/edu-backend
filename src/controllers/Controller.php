<?php
namespace App\Controller;

class Controller
{
    protected  $_di;

    function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }
}