<?php
namespace App\Controller;

use App\Model\Quote;

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
        if(isset($_POST['region_id'])) {var_dump($_POST['region_id']);die;}
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
        $factory = $this->_di->get('ShippingFactory');
        $factory->setAddress($quote->getAddress());
        $methods = $factory->getMethods();
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
                'shipping_code'=>$shipping_code
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
            $this->_redirect('checkout_order');
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
        $quote = $this->_initQuote();
        $quote->collectTotals();
        $quote->save();
        $prototype = $this->_di->get('Product',['data'=>[]]);
        $products = $quote->getItems()->assignProducts($prototype);

        if($this->_isPost())
        {
            $order = $this->_di->get('Order' ,['data'=>[]]);
            $this->_di->get('QuoteConverter')->toOrder($quote,$order);
            $order->save();
            $order->sendMail();
        }

        return $this->_di->get('View',[
            'template'=>'checkout_order',
            'params'=>[
                'quote'=>$quote,
                'address'=>$quote->getAddress(),
                'products'=>$products,
                'shipping_label'=>$this->_getLabels($quote)['shipping_label'],
                'payment_label'=>$this->_getLabels($quote)['payment_label']
            ]
        ]);
    }

    private function _getLabels(Quote $quote)
    {
        $shippingMethod = '';
        $paymentMethod = '';
        $factory = $this->_di->get('ShippingFactory');
        $factory->setAddress($quote->getAddress());
        $methods = $factory->getMethods();
        foreach ($methods as $method)
        {
            if($quote->getShippingCode() == $method->getCode())
            {
                $shippingMethod = $method->getLabel();
            }
        }

        $methods = $this->_di->get('PaymentFactory',['address'=>$quote->getAddress()])
            ->getMethods()
            ->avaliable();
        foreach ($methods as $method)
        {
            if($quote->getPaymentCode() == $method->getCode())
            {
                $paymentMethod = $method->getLabel();
            }
        }
        return [
            'shipping_label'=>$shippingMethod,
            'payment_label'=>$paymentMethod
        ];
    }
}