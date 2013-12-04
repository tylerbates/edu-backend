<?php
namespace App;

require_once __DIR__ . '/../autoloader.php';

ini_set('display_errors', 1);

try
{
    $defaultPath = 'product_list';
    $routePath = isset($_GET['page']) ? $_GET['page'] : $defaultPath ;

    $router = new Model\Router($routePath);
    $controllerName = $router->getController();
    $controller = new $controllerName;
    $actionName = $router->getAction();
    $controller->$actionName();
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
        $controller = new Controller\ProductController();
        $controller->listAction();
    }
}



