<?php
namespace App\Controller;

class NotFoundController
{
    public function notFoundAction()
    {
        $view = 'not_found';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }
}