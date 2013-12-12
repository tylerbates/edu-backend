<?php
namespace App\Controller;

use App\Model\Customer;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Session;

class CustomerController extends Controller
{
    public function  exitAction()
    {
        $session = new Session();
        $session->unsetUser();
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
            $session = new Session();
            $session->setUser(['customer_id'=>(int) $logged_in[0]['customer_id'],'name'=>$logged_in[0]['name']]);
        }
        $view = 'customer_login';
        require_once __DIR__ . '/../views/layout/base.phtml';
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
        return  $customer->getId();
    }
}