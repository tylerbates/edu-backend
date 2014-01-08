<?php
namespace App\Controller;


class AdminController extends Controller
{
    public function loginAction()
    {
        if(!($_GET['magic_word']=='please'))
        {
            $this->_redirect('product_list');
        }
        else echo "ololo";
    }
} 