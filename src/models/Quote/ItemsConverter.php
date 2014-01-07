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
            $_items[] = implode(',',[$product->getId(),$product->getName(),$product->getQty()]);

            //$items .= '_|' . $product->getId() . '|' . $product->getName() . '|' . $product->getQty() . '|';
        }
        $items = implode('|',$_items);
        $order->setItems($items);
    }
}