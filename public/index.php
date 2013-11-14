<?php
//ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/Router.php';

try
{
    $router = new Router($_GET['page']);
    $controllerName = $router->getController();
    require_once __DIR__ . "/../src/controllers/{$controllerName}.php";
    $controller = new $controllerName;
    $actionName = $router->getAction();
    $controller->$actionName();
}
catch (NotFoundException $e)
{
    require_once __DIR__ . "/../src/controllers/NotFoundController.php";
    $controller = new NotFoundController();
    $controller->notFoundAction();
}
catch (DefaultPageException $e)
{
    require_once __DIR__ . "/../src/controllers/ProductController.php";
    $controller = new ProductController();
    $controller->listAction();
}


