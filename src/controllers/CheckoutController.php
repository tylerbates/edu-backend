<?php
namespace App\Controller;

use App\Model\Resource\Table\Address as AddressTable;
use App\Model\Shipping\Factory;

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
            'params'=>['regions'=>$regions,'cities'=>$cities, 'address'=>$address]
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
            $this->_redirect('checkout_shipping');
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
}