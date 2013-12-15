<?php
namespace App\Model;
use App\Model\Session;
use App\Model\Product;
use App\Model\Resource\IResourceEntity;

class Quote
{
    private $_data = array();
    private $_resource;

    public function __construct(IResourceEntity $resource)
    {
        $this->_resource = $resource;
    }


    public function loadByCustomer($customer_id)
    {
        $this->_data = $this->_resource->find(['customer_id'=>$customer_id]);
    }

    public function loadBySession(Session $session)
    {
        foreach ($session->getQuote() as $link_id)
        {
            $this->_data = $this->_resource->find(['link_id'=>$link_id]);
        }
    }

    public function getItemForProduct(Product $product, $customer_id, $link_id)
    {
        if(!$customer_id) $customer_id = 0;
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