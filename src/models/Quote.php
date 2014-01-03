<?php
namespace App\Model;
use App\Model\Session;
use App\Model\Product;
use App\Model\Resource\IResourceEntity;
use App\Model\Shipping\Factory;

class Quote extends Entity
{
    private $_items;
    private $_address;

    public function __construct(
        array $data = [],
        Resource\IResourceEntity $resource = null,
        QuoteItemCollection $items = null,
        Address $address = null
    ) {
        $this->_items =  $items;
        $this->_address = $address;
        parent::__construct($data, $resource);
    }

    public function loadBySession(Session $session)
    {
        if($quoteId = $session->getQuoteId())
        {
            $this->load($session->getQuoteId(),'quote_id');
        } else
        {
            $this->save();
            $session->setQuoteId($this->getId());
        }
    }

    public function loadByCustomer(Session $session)
    {
        if ($this->_resource->find(['customer_id'=>$session->getUserId()]))
        {
            $this->load((int) $session->getUserId(),'customer_id');
            $session->setQuoteId($this->getId());
        } else
        {
            $this->_data['customer_id'] = $session->getUserId();
            $this->save();
            $session->setQuoteId($this->getId());
        }
    }

    public function setItems()
    {
        $this->_items->filterByQuote($this);
    }

    public function getItems()
    {
        return $this->_items->getItems();
    }

    public function getAddress()
    {
        if($addressId = $this->getData('address_id'))
        {
            $this->_address->load($this->getData('address_id'),'address_id');
        } else
        {
            $this->_address->save();
            $this->_assignAddress();
        }
        return $this->_address;
    }

    private function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }

    public function getShippingCode()
    {
        return $this->_data['shipping_code'];
    }

    public function setShippingMethod($code)
    {
        $this->_data['shipping_code'] = $code;
    }
}