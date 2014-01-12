<?php
namespace App\Model\Quote;

use App\Model\Order;
use App\Model\Product;
use App\Model\Quote;

class ItemsConverter implements IConverter
{
    private $_prototype;

    public function __construct(Product $prototype)
    {
        $this->_prototype = $prototype;
    }

    public function toOrder(Quote $quote, Order $order)
    {
        $_items = [];
        $products = $quote->getItems()->assignProducts($this->_prototype);
        foreach ($products as $product)
        {
            $price = $product->isSpecialPriceApplied() ? $product->getSpecialPrice() : $product->getPrice();
            $_items[] = implode(',',[
                $product->getName(),
                $product->getSku(),
                $product->getQty(),
                $price,
                $price*$product->getQty()
            ]);
        }
        $items = implode('|',$_items);
        $order->setItems($items);
    }
}