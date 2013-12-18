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
        foreach($_SESSION['quote'] as $key => $itemId)
        {
            if((int) $itemId == $link_id) unset($_SESSION['quote'][$key]);
        }
    }

    public function generateToken()
    {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function validateToken($token)
    {
        $valid = $this->getToken() === $token;
        unset($_SESSION['token']);
        return $valid;
    }

    public function getToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }
}