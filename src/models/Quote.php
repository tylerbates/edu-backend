<?php
namespace App\Model;
use App\Model\Session;
use App\Model\Product;
use App\Model\Resource\IResourceEntity;
use App\Model\Shipping\Factory;

class Quote extends Entity
{
    public function loadBySession(Session $session)
    {
        if ($quoteId = $session->getQuoteId())
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

    public function getItemForProduct(QuoteItem $prototype, Product $product, $link_id = null)
    {
        $prototype->assignToQuote($this);
        $prototype->assignToProduct($product);
        $prototype->setLink($link_id);
        return $prototype;
    }

    public function setAddress(Address $address)
    {
        $this->_data['address_id'] = $address->getId();
        $this->save();
    }

    public function getAddress()
    {
        return $this->_data['address_id'];
    }

    public function setShippingCode($code)
    {
        $this->_data['shipping_code'] = $code;
        $this->save();
    }
}