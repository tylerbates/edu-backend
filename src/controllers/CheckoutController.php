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
        echo 'ololo';
    }
}