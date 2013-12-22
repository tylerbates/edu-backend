<?php
namespace App\Model;

class QuoteItem extends Entity
{
    public function assignToProduct(Product $product)
    {
        $this->_data['product_id'] = (int)$product->getId();
    }

    public function assignToQuote(Quote $quote)
    {
        $this->_data['quote_id'] = (int)$quote->getId();
    }

    public function addQty($qty)
    {
        if(isset($this->_data['qty']))
        {
            $this->_data['qty'] = $this->_data['qty'] + (int)$qty;
        }else
        {
            $this->_data['qty'] = (int)$qty;
        }
    }

    public function updateQty($qty)
    {
        $this->_data['qty'] = (int)$qty;
    }

    public function getProductId()
    {
        return $this->_data['product_id'];
    }

    public function getQty()
    {
        return $this->_data['qty'];
    }

    public function getLinkId()
    {
        return $this->_data['link_id'];
    }

    public function setLink($link_id)
    {
        $this->_data['link_id'] = $link_id;
    }

    public function delete()
    {
        $this->_resource->delete($this->_data['link_id']);
    }
}