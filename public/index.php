<?php
namespace App;

use App\Controller\BasketController;
use App\Model\Session;

require_once __DIR__ . '/../autoloader.php';
ini_set('display_errors', 1);
ini_set('session.auto_start', 1);

$di = new \Zend\Di\Di();
(new \App\Model\DiC($di))->assemble();
try
{
    $defaultPath = 'product_list';
    $routePath = isset($_GET['page']) ? $_GET['page'] : $defaultPath ;
    $router = new Model\Router($routePath);
    $controllerName = $router->getController();
    $actionName = $router->getAction();
}
catch (Model\RouterException $e)
{
    if($e->getMessage() == 'Page not found')
    {
        $controller = new Controller\NotFoundController();
        $controller->notFoundAction();
    }
    elseif($e->getMessage() == 'Redirecting on default page')
    {
        $controller = new Controller\ProductController($di);
        $controller->listAction();
    }
}

$controller = new $controllerName($di);
if($view = $controller->$actionName())
{
    $view->render();
}

