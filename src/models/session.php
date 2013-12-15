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

    public function getQuote()
    {
        return $_SESSION['quote'];
    }

    public function addQuoteItem($link_id)
    {
        $_SESSION['quote'][] = $link_id;
    }

    public function deleteQuoteItem($link_id)
    {
        var_dump($link_id);
        foreach($_SESSION['quote'] as $key => $itemId)
        {
            var_dump((int) $itemId);
            if((int) $itemId == $link_id) unset($_SESSION['quote'][$key]);
        }
    }
}