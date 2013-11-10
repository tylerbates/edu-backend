<?php
class Router
{
    private $_controller;
    private $_action;
    private $route_valid;

    public function __construct($route)
    {
        if(!$route)
        {
            $this->_controller = 'product';
            $this->_action = 'list';
        }
        else list($this->_controller, $this->_action) = explode('_', $route);
        $this->_controller = ucfirst(strtolower($this->_controller)) . 'Controller';
        $this->_action = strtolower($this->_action) . 'Action';
        $this->route_valid = $this->_validateRoute();
    }

    public function getController()
    {
        if($this->route_valid) return $this->_controller;
        return 'NotFoundController';
    }

    public function getAction()
    {
       if($this->route_valid) return $this->_action;
        return 'notFoundAction';
    }

    private function _validateRoute()
    {
        if(!$this->_action)
        {
            return false;
        }

        include_once __DIR__ . '/../controllers/' . $this->_controller . '.php';

        if(!class_exists($this->_controller) || !method_exists($this->_controller, $this->_action))
        {
            return false;
        }
        else return true;
    }
}