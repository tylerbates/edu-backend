<?php
namespace App\Controller;

class CheckoutController extends SalesController
{
    public function addressAction()
    {
        $_regions = $this->_di->get('RegionCollection');
        $regions = $_regions->getRegions();
        $_cities = $this->_di->get('CityCollection');
        $cities = $_cities->getCities();
        $quote = $this->_initQuote();
        $address = $quote->getAddress();
        if (isset($_POST['address']))
        {
            $address->setData($_POST['address']);
            $address->save();
            $this->_redirect('checkout_shipping');
        }
        return $this->_di->get('View',[
            'template'=>'checkout_address',
            'params'=>[
                'regions'=>$regions,
                'cities'=>$cities,
                'address'=>$address
            ]
        ]);
    }

    public function shippingAction()
    {
        $quote = $this->_initQuote();
        $methods = $this->_di->get('ShippingFactory', ['address'=>$quote->getAddress()])->getMethods();
        $shipping_code = $quote->getShippingCode();
        if(isset($_POST['shipping']))
        {
            $quote->setShippingMethod($_POST['shipping']);
            $quote->save();
            $this->_redirect('checkout_payment');
        }
        return $this->_di->get('View',[
            'template'=>'checkout_shipping',
            'params'=>[
                'methods'=>$methods,
                'shipping_code'=>$shipping_code,
                'address'=>$quote->getAddress()->getCity()
            ]
        ]);
    }

    public function paymentAction()
    {
        $quote = $this->_initQuote();
        $methods = $this->_di->get('PaymentFactory',['address'=>$quote->getAddress()])
            ->getMethods()
            ->avaliable();
        $payment_code = $quote->getPaymentCode();
        if(isset($_POST['payment']))
        {
            $quote->setPaymentMethod($_POST['payment']);
            $quote->save();
            $this->_redirect('checkout_payment');
        }
        return $this->_di->get('View',[
            'template'=>'checkout_payment',
            'params'=>[
                'methods'=>$methods,
                'payment_code'=>$payment_code
            ]
        ]);
    }

    public function orderAction()
    {

    }
}