<?php
namespace App\Model;

class Product extends Entity
{
    public function getId()
    {
        return $this->_getData('product_id');
    }

    public function getSku()
    {
        return $this->_getData('sku');
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function getImage()
    {
        return $this->_getData('image');
    }

    public function getPrice()
    {
        return $this->_getData('price');
    }

    public function getSpecialPrice()
    {
        return $this->_getData('special_price');
    }

    public function isSpecialPriceApplied()
    {
        return $this->getSpecialPrice() > 0;
    }

    public function setQty($qty)
    {
        $this->_data['qty'] = $qty;
    }

    public function getQty()
    {
        return $this->_getData('qty');
    }

    public function setLink($link_id)
    {
        $this->_data['link_id'] = $link_id;
    }

    public function getLink()
    {
        return $this->_getData('link_id');
    }

    public function setData($data)
    {
        $this->_data = $data;
    }
}
