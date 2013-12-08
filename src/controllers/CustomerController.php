<?php
namespace App\Controller;

use App\Model\Customer;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Resource\Table\Basket as BasketTable;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Session;
use App\Model\Product;
use App\Controller\ProductController;

class CustomerController extends Controller
{
    public function  exitAction()
    {
        Session::unsetUser();
        header('Location: /');
    }

    public function loginAction()
    {
        $logged_in = false;
        $resource = new DBCollection($this->_connection,new CustomerTable);
        if(isset($_POST['customer']))
        {
            $info = $_POST['customer'];
            $info['password'] = md5($info['password']);
            $resource->filterBy('name',$info['name']);
            $resource->filterBy('password',$info['password']);
            $logged_in = $resource->fetch();
        }
        if($logged_in)
        {
            Session::setUser(['customer_id'=>(int) $logged_in[0]['customer_id'],'name'=>$logged_in[0]['name']]);
            $this->_setBasket();
        }
        $view = 'customer_login';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    private function _setBasket()
    {
        $resource = new DBCollection($this->_connection,new BasketTable);
        $resource->filterBy('customer_id',Session::getUserId());
        $basket_id = (int) $resource->fetch()[0]['basket_id'];
        Session::setBasket($basket_id);
    }

    public function registerAction()
    {
        $registered = false;
        if(isset($_POST['customer']))
        {
            $registered = $this->_registerCustomer();
        }
        $view = 'customer_register';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    private function _registerCustomer()
    {
        $resource = new DBEntity($this->_connection,new CustomerTable);
        $info = $_POST['customer'];
        $info['password'] = md5($info['password']);
        $customer = new Customer($info);
        $customer->save($resource);
        $basket_controller = new BasketController();
        $basket_controller->createAction($customer->getId());
        return  $customer->getId();
    }

    public function registerAnonymous()
    {
        $rand = rand(2000000000,2147483647);
        $info = ['customer_id'=>$rand,'name'=>'anonymous' . $rand];
        $resource = new DBEntity($this->_connection,new CustomerTable);
        $customer = new Customer($info);
        $customer->save($resource);
        return $customer->getId();
    }
}