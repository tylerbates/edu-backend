<?php
//ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/Router.php';

$router = new Router($_GET['page']);

$controllerName = $router->getController();

//var_dump($controllerName);

require_once __DIR__ . "/../src/controllers/{$controllerName}.php";

$controller = new $controllerName;

$actionName = $router->getAction();

//var_dump($actionName);

$controller->$actionName();