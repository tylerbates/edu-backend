<?php
namespace App\Model;

class QuoteItem extends Entity
{
    private $_product;

    public function assignToProduct(Product $product)
    {
        $this->_data['product_id'] = (int)$product->getId();
        $this->_product = $product;
    }

    public function getProduct()
    {
        return $this->_product;
    }

    public function assignToQuote(Quote $quote)
    {
        $this->_data['quote_id'] = (int)$quote->getId();
    }

    public function belongsToQuote(Quote $quote)
    {
        return $this->_data['quote_id'] == $quote->getId();
    }

    public function belongsToProduct(Product $product)
    {
        return $this->_data['product_id'] == $product->getId();
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

    public function setData($data)
    {
        $this->_data = $data;
    }
}