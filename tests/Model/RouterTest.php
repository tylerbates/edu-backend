<?php
namespace Test\Model;

use App\Model\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testRouterParsesEmptyGetRequest()
    {
        $this->setExpectedException('\App\Model\RouterException','Redirecting on default page');
        $router = new Router(null);
    }

    public function testRouterParsesProductListRequest()
    {
        $router = new Router('product_list');
        $this->assertEquals('\App\Controller\ProductController', $router->getController());
        $this->assertEquals('listAction', $router->getAction());
    }

    public function testRouterParsesProductViewRequest()
    {
        $router = new Router('product_view');
        $this->assertEquals('\App\Controller\ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());
    }

    public function testRouterParsesRequestWithCapitals()
    {
        $router = new Router('Product_View');
        $this->assertEquals('\App\Controller\ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());

        $router = new Router('ProDuct_VieW');
        $this->assertEquals('\App\Controller\ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());

        $router = new Router('PRODUCT_VIEW');
        $this->assertEquals('\App\Controller\ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());
    }

    public function testRouterParsesRequestWithoutSplit()
    {
        $this->setExpectedException('\App\Model\RouterException','Page not found');
        $router = new Router('productview');
    }

    public function testRouterParsesWrongClassOrMethodRequest()
    {
        $this->setExpectedException('\App\Model\RouterException','Page not found');
        $router = new Router('view_product');
        $router = new Router('sdgasdh_gfjfdgj');
    }
}