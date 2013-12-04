<?php
namespace App\Model;


class Router
{
    private $_controller;
    private $_action;

    public function __construct($route)
    {
        $this->_validateRoute($route);
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function getAction()
    {
        return $this->_action;
    }

    private function _validateRoute($route)
    {
        if(!$route)
        {
            throw new RouterException('Redirecting on default page');
        }

        if(!strpos($route,'_') || count(explode('_', $route))>2)
        {
            throw new RouterException('Page not found');
        }

        list($this->_controller, $this->_action) = explode('_', $route);
        $this->_controller = '\\App\\Controller\\' . ucfirst(strtolower($this->_controller)) . 'Controller';
        $this->_action = strtolower($this->_action) . 'Action';

        if(!class_exists($this->_controller) || !method_exists($this->_controller, $this->_action))
        {
            throw new RouterException('Page not found');
        }

    }
}