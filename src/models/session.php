<?php
namespace App\Model;
use App\Controller\BasketController;
use App\Controller\CustomerController;

class Session
{
    public function __construct()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!$this->isAuthorized())
        {
            $controller = new CustomerController();
            $customer_id = $controller->registerAnonymous();
            Session::setUser(['customer_id'=>$customer_id]);
            $controller = new BasketController();
            Session::setBasket($controller->createAnonymous());
        }
    }

    public static function setUser($user_info)
    {
        $_SESSION['user'] = $user_info;
    }

    public static function isAuthorized()
    {
        return isset($_SESSION['user']);
    }

    public static function unsetUser()
    {
        unset($_SESSION['user'],$_SESSION['basket']);
    }

    public static function getUserId()
    {
        return $_SESSION['user']['customer_id'];
    }

    public static function setBasket($id)
    {
        $_SESSION['basket'] = ['basket_id'=>$id];
    }

    public static function getBasket()
    {
        return $_SESSION['basket']['basket_id'];
    }

    public static function getUserName()
    {
        return $_SESSION['user']['name'];
    }

    public static function isUserNameSet()
    {
        return isset($_SESSION['user']['name']);
    }
}