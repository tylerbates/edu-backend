<?php
namespace App\Model;
use App\Model\Session;
use App\Model\Product;
use App\Model\Resource\IResourceEntity;

class Quote
{
    private $_data = array();

    public function loadByCustomer(IResourceEntity $resource ,$customer_id)
    {
        $this->_data = $resource->find(['customer_id'=>$customer_id]);
    }

    public function loadBySession(Session $session)
    {
        $this->_data = $session->getProducts();
    }

    public function getItemForProduct(Product $product, $customer_id, $link_id)
    {
        return $quoteItem = new QuoteItem(['customer_id'=>$customer_id,'product_id'=>(int) $product->getId(), 'link_id'=>$link_id]);
    }

    public function getProducts()
    {
        return array_map(function($item){
            return new QuoteItem($item);
        },$this->_data);
    }

    public function getCustomerId()
    {
        return $this->_data['customer_id'];
    }
}