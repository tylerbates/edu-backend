<?php
class NotFoundException extends Exception{}
class DefaultPageException extends Exception{}

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
            throw new DefaultPageException();
        }

        if(!strpos($route,'_') || count(explode('_', $route))>2)
        {
            throw new NotFoundException();
        }

        list($this->_controller, $this->_action) = explode('_', $route);
        $this->_controller = ucfirst(strtolower($this->_controller)) . 'Controller';
        $this->_action = strtolower($this->_action) . 'Action';

        if(!file_exists(__DIR__ . '/../controllers/' . $this->_controller . '.php'))
        {
            throw new NotFoundException();
        }

        include_once __DIR__ . '/../controllers/' . $this->_controller . '.php';

        if(!class_exists($this->_controller) || !method_exists($this->_controller, $this->_action))
        {
            throw new NotFoundException();
        }

    }
}