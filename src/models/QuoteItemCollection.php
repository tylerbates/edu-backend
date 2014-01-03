<?php
namespace App\Model;


class QuoteItemCollection extends EntityCollection
{
    private $_items = [];
    private $_prototype;

    public function __construct(Resource\IResourceCollection $resource, QuoteItem $itemPrototype)
    {
        $this->_prototype = $itemPrototype;
        parent::__construct($resource);
    }
    
    public function filterByQuote(Quote $quote)
    {
        $this->_resource->filterBy('quote_id', (int)$quote->getId());
        $this->_getItems();
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
        return $this->_items = array_map(function($data){
            $item = clone $this->_prototype;
            $item->setData($data);
            return $item;
        },$this->_resource->fetch());
    }

    public function getItems()
    {
        return $this;
    }

    public function forProduct(Product $product,Quote $quote)
    {
        if($item = $this->_findByProduct($product, $quote))
        {
            return $item;
        }

        $newItem = clone $this->_prototype;
        $newItem->assignToProduct($product);
        $newItem->assignToQuote($quote);
        return $newItem;
    }

    private function _findByProduct(Product $product, Quote $quote)
    {
        foreach($this->_getItems() as $_item)
        {
            if($_item->belongsToQuote($quote) && $_item->belongsToProduct($product))
            {
                return $_item;
            }
        }
    }
}