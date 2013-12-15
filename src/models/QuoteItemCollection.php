<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class QuoteItemCollection extends EntityCollection
{
    public function filterByQuote(Quote $quote)
    {
        $this->_resource->filterBy('customer_id', $quote->getCustomerId());
    }

    public function assignProducts(Product $prototype)
    {
        $products = [];
        foreach($this->getProducts() as $_item)
        {
            $product = clone $prototype;
            $product->load($_item->getProductId(),'product_id');
            $product->setQty($_item->getQty());
            $product->setLink($_item->getId());
            $products[] = $product;
        }
        return $products;
    }

    public function getProducts()
    {
        return array_map(function($item){
            return new QuoteItem($item);
        },$this->_resource->fetch());
    }
}