<?php
namespace App\Model;

class Session
{
    public function __construct()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
    }

    public function setUser($user_info)
    {
        $_SESSION['user'] = $user_info;
    }

    public function isAuthorized()
    {
        return isset($_SESSION['user']);
    }

    public function unsetUser()
    {
        unset($_SESSION['user']);
    }

    public function getUserId()
    {
        return $_SESSION['user']['customer_id'];
    }

    public function getUserName()
    {
        return $_SESSION['user']['name'];
    }

    public function isUserNameSet()
    {
        return isset($_SESSION['user']['name']);
    }

    public function getProducts()
    {
        return $_SESSION['products'];
    }

    public function addProduct(QuoteItem $quote_item)
    {
        $_SESSION['products'][] = [
            'product_id'=>$quote_item->getProductId(),
            'qty'=>$quote_item->getQty()
        ];
    }
}