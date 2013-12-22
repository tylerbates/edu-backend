<?php
namespace App\Model;

class QuoteItemCollection extends EntityCollection
{
    public function filterByQuote(Quote $quote)
    {
        $this->_resource->filterBy('quote_id', $quote->getId());
    }

    public function assignProducts(Product $prototype)
    {
        $products = [];
        foreach($this->_getItems() as $_item)
        {
            $product = clone $prototype;
            $product->load($_item->getProductId(),'product_id');
            $product->setQty($_item->getQty());
            $product->setLink($_item->getLinkId());
            $products[] = $product;
        }
        return $products;
    }

    private function _getItems()
    {
        return array_map(function($item){
            return new QuoteItem($item);
        },$this->_resource->fetch());
    }
}