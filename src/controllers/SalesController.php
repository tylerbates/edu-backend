<?php
namespace App\Controller;

class SalesController extends Controller
{
    protected function _initQuote()
    {
        $quote =$this->_di->get('Quote',['data'=>[]]);
        $session = $this->_di->get('Session');
        if($session->isAuthorized())
        {
            $quote->loadByCustomer($session);
            return $quote;
        } else
        {
            $quote->loadBySession($session);
            return $quote;
        }
    }
} 