<?php
namespace App\Controller;

class NotFoundController extends Controller
{
    public function notFoundAction()
    {
        return $this->_di->get('View',['template'=>'not_found']);
    }
}