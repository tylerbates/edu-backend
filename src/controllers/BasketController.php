<?php
namespace App\Controller;

use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Basket as BasketTable;
use App\Model\Resource\Table\BasketProducts as BasketProductsTable;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Basket;
use App\Model\Session;
use App\Model\ProductCollection;

class BasketController extends Controller
{
    public function addAction()
    {
        $data = ['product_id'=>$_GET['id'],'basket_id'=>Session::getBasket()];
        $resource = new DBEntity($this->_connection,new BasketProductsTable);
        $resource->save($data);
        header('Location: /?page=product_list');
    }

    public function createAction($id)
    {
        $id = ['customer_id'=>$id];
        $resource = new DBEntity($this->_connection,new BasketTable);
        $basket = new Basket($id);
        $basket->create($resource);
    }

    public function createAnonymous()
    {
        $id = ['basket_id'=>rand(2000000000,2147483647),'customer_id'=>Session::getUserId()];
        $resource = new DBEntity($this->_connection,new BasketTable);
        $basket = new Basket($id);
        $basket->create($resource);
        return $basket->getId();
    }

    public function viewAction()
    {
        $resource = new DBCollection($this->_connection, new ProductTable);

        $_products = new ProductCollection($resource);
        $products = $_products->getBasketProducts(Session::getUserId());
        $view = 'basket_view';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    public function deleteAction()
    {
        $resource = new DBCollection($this->_connection,new BasketProductsTable);
        $resource->filterBy('product_id',(int) $_GET['id']);
        $resource->filterBy('basket_id',Session::getBasket());
        $resource->delete();
        header('Location: /?page=basket_view');
    }
}