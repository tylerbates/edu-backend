<?php
namespace App\Controller;

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
        $resource = $this->_di->get('ResourceCollection',['table' => new CustomerTable()]);
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
        return $this->_di->get('View',[
            'template'=>'customer_login',
            'params'=>['customer'=>$logged_in]
        ]);
    }

    public function registerAction()
    {
        $registered = false;
        if(isset($_POST['customer']))
        {
            $registered = $this->_registerCustomer();
        }
        return $this->_di->get('View',[
            'template'=>'customer_register',
            'params'=>['result'=>$registered]
        ]);
    }

    private function _registerCustomer()
    {
        $resource = $this->_di->get('ResourceEntity',['table' => new CustomerTable()]);

        $info = $_POST['customer'];
        $info['password'] = md5($info['password']);
        $customer = $this->_di->get('Customer', ['data'=>$info]);
        $customer->save($resource);
        return  $customer->getId();
    }
}