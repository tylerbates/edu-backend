<?php
require_once __DIR__ . '/../src/models/Router.php';

//error_reporting(0);
//tests for wrong requests don't work if error reporting is on))
// P.S. but router is ok!

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testRouterParsesEmptyGetRequest()
    {
        try
        {
            $router = new Router(null);
        }
        catch (DefaultPageException $e)
        {
            return;
        }
        $this->fail('Exception was not caught');
    }

    public function testRouterParsesProductListRequest()
    {
        $router = new Router('product_list');
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('listAction', $router->getAction());
    }

    public function testRouterParsesProductViewRequest()
    {
        $router = new Router('product_view');
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());
    }

    public function testRouterParsesRequestWithCapitals()
    {
        $router = new Router('Product_View');
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());

        $router = new Router('ProDuct_VieW');
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());

        $router = new Router('PRODUCT_VIEW');
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('viewAction', $router->getAction());
    }

    public function testRouterParsesRequestWithoutSplit()
    {
        try
        {
            $router = new Router('productview');
        }
        catch (NotFoundException $e)
        {
            return;
        }
        $this->fail('Exception was not caught');
    }

    public function testRouterParsesWrongClassOrMethodRequest()
    {
        try
        {
            $router = new Router('view_product');
        }
        catch (NotFoundException $e)
        {
            return;
        }
        $this->fail('Exception was not caught');

        try
        {
            $router = new Router('sdgasdh_gfjfdgj');
        }
        catch (NotFoundException $e)
        {
            return;
        }
        $this->fail('Exception was not caught');
    }
}