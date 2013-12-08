<?php
namespace App\Controller;

use App\Model\Resource\DBConfig;

class Controller
{
    protected  $_connection;

    function __construct()
    {
        $this->_connection = DBConfig::connect();
    }

    function __destruct()
    {
        unset($this->_connection);
    }
}