<?php
namespace App\Controller;

class Controller
{
    protected  $_di;

    function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }

    protected function _redirect($page, $params = [])
    {
        $urlParams = ['page' => $page];
        $urlParams = array_merge($urlParams, $params);
        header('Location: /?' . \http_build_query($urlParams));
    }
}