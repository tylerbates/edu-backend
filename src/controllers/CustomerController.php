<?php
namespace App\Controller;

use App\Model\Resource\Table\Customer as CustomerTable;

class CustomerController extends SalesController
{
    public function  exitAction()
    {
        $session = $this->_di->get('Session');
        $session->unsetUser();
        $this->_redirect('product_list');
    }

    public function loginAction()
    {
        $logged_in = false;
        $resource = $this->_di->get('ResourceCollection',['table' => new CustomerTable()]);
        if(isset($_POST['customer']))
        {
            $info = $_POST['customer'];
            $info['password'] = md5($info['password']);
            $resource->filterBy('email',$info['email']);
            $resource->filterBy('password',$info['password']);
            $logged_in = $resource->fetch();
        }
        if($logged_in)
        {
            $session = $this->_di->get('Session');
            $session->setUser([
                'customer_id'=>(int) $logged_in[0]['customer_id'],
                'name'=>$logged_in[0]['name'],
                'email'=>$logged_in[0]['email']
            ]);
            $this->_initQuote();
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
        $items = $this->_initQuote()->getItems();

        $info = $_POST['customer'];
        $info['password'] = md5($info['password']);
        $customer = $this->_di->get('Customer', ['data'=>[]]);
        $customer->setData($info);
        $customer->save();
        $session = $this->_di->get('Session');
        $session->setUser([
            'customer_id' => (int) $customer->getId(),
            'name'=>$customer->getName(),
            'email'=>$customer->getEmail()
        ]);
        $quote = $this->_initQuote();
        $items->assignToQuote($quote);
        return  $customer->getId();
    }
}