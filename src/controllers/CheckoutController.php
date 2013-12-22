<?php
namespace App\Controller;

use App\Model\Resource\Table\Address as AddressTable;
use App\Model\Shipping\Factory;

class CheckoutController extends SalesController
{
    public function addressAction()
    {
        if(isset($_POST['address']))
        {
            $quote = $this->_initQuote();
            $resource = $this->_di->get('ResourceEntity',['table'=>new AddressTable()]);
            $address = $this->_di->get('Address',['resource'=>$resource,'data'=>$_POST['address']]);
            $address->save();
            $quote->setAddress($address);
            $this->_redirect('checkout_shipping');
        }else
        {
            return $this->_di->get('View',['template'=>'checkout_address']);
        }
    }

    public function shippingAction()
    {
        if(isset($_POST['code']))
        {
            $quote = $this->_initQuote();
            $resource = $this->_di->get('ResourceEntity',['table'=>new AddressTable()]);
            $address = $this->_di->get('Address',['resource'=>$resource,'data'=>[]]);
            $address->load($quote->getAddress(), 'address_id');
            $factory = new Factory($address);
            $quote->setShippingCode($_POST['code']);
        }


        return $this->_di->get('View',['template'=>'checkout_shipping']);
    }
}