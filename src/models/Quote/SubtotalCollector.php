<?php
namespace App\Model\Quote;

use App\Model\Product;
use App\Model\Quote;

class SubtotalCollector implements ICollector
{
    private $_prototype;

    public function __construct(Product $prototype)
    {
        $this->_prototype = $prototype;
    }

    public function collect(Quote $quote)
    {
        $subtotal = 0;
        $products = $quote->getItems()->assignProducts($this->_prototype);
        foreach($products as $product)
        {
            $qty = $product->getQty();
            $price = $product->isSpecialPriceApplied() ? $product->getSpecialPrice() : $product->getPrice();
            $subtotal += $price * $qty;
        }
        return $subtotal;
    }
} 