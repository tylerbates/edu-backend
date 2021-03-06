<?php
namespace App\Model;
use App\Model\Quote\CollectorsFactory;
use App\Model\Session;
use App\Model\Product;
use App\Model\Resource\IResourceEntity;
use App\Model\Shipping\Factory;

class Quote extends Entity
{
    private $_items;
    private $_address;
    private $_collectorsFactory;

    public function __construct(
        array $data = [],
        Resource\IResourceEntity $resource = null,
        QuoteItemCollection $items = null,
        Address $address = null,
        CollectorsFactory $collectorsFactory = null
    ) {
        $this->_items =  $items;
        $this->_address = $address;
        $this->_collectorsFactory = $collectorsFactory;
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
            $this->load((int) $session->getUserId(),'customer_id');
            $session->setQuoteId($this->getId());
        }
    }

    public function initItems()
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
        return $this->getData('shipping_code');
    }

    public function setShippingMethod($code)
    {
        $this->_data['shipping_code'] = $code;
    }

    public function getPaymentCode()
    {
        return $this->getData('payment_code');
    }

    public function setPaymentMethod($code)
    {
        $this->_data['payment_code'] = $code;
    }

    public function collectTotals()
    {
        foreach($this->_collectorsFactory->getCollectors() as $field => $collector)
        {
            $this->_data[$field] = $collector->collect($this);
        }
    }

    public function getSubtotal()
    {
        return $this->getData('subtotal');
    }

    public function getShipping()
    {
        return $this->getData('shipping');
    }

    public function getGrandTotal()
    {
        return $this->getData('grand_total');
    }

    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }
}