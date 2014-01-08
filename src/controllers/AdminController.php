<?php
namespace App\Controller;


class AdminController extends Controller
{
    public function exitAction()
    {
        $session = $this->_di->get('Session');
        $session->unsetUser();
        $this->_redirect('product_list');
    }

    public function loginAction()
    {
        if(!($_GET['magic_word']=='please'))
        {
            $this->_redirect('product_list');
        } else
        {
            $admin = null;

            if(isset($_POST['admin']))
            {
                $admin = $this->_di->get('Admin',['data'=>[]]);
                $info = $_POST['admin'];
                if($admin->logIn($info['name'],$info['password']))
                {
                    $session = $this->_di->get('Session');
                    $session->setUser(['admin_id'=>$admin->getId(),'name'=>$admin->getName()]);
                    $this->_redirect('manage_product');
                }
                else $this->_redirect('admin_login',['magic_word'=>'please']);
            }

            return $this->_di->get('View',[
                'template'=>'admin_login',
                'params'=>['admin'=>$admin]
            ]);
        }
    }
} 