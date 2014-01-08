<?php
namespace App\Controller;


class ManageController extends Controller
{
    public function productAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            $prototype = $this->_di->get('Product',['data'=>[]]);
            $products = $this->_di->get('ProductCollection',['prototype'=>$prototype]);

            return $this->_di->get('View',[
                'template'=>'manage_product',
                'params'=>[
                    'products'=>$products
                ]
            ]);
        }
    }

    public function reviewAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_review'
            ]);
        }
    }

    public function customerAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_customer'
            ]);
        }
    }

    public function orderAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_order'
            ]);
        }
    }

    public function couponAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_coupon'
            ]);
        }
    }

    public function shippingAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            $collection = $this->_di->get('ShippingPriceCollection');
            $cities = $this->_di->get('CityCollection');
            return $this->_di->get('View',[
                'template'=>'manage_shipping',
                'params'=>[
                    'collection'=>$collection,
                    'cities'=>$cities
                ]
            ]);
        }
    }
} 