<?php
namespace App\Controller;

use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use App\Model\Resource\Table\Product as ProductTable;

class QuoteController extends SalesController
{
    public function addAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->addQty((int) $_POST['qty']);
        $quoteItem->save();
        $this->_redirect('product_list');
    }

    public function updateAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->updateQty($_POST['qty']);
        $quoteItem->save();
        $this->_redirect('quote_list');
    }

    public function deleteAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->delete();
        $this->_redirect('quote_list');
    }

    public function listAction()
    {
        $quote = $this->_initQuote();
        $prototype = $this->_di->get('Product',['data'=>[]]);
        $products = $quote->getItems()->assignProducts($prototype);
        return $this->_di->get('View',[
            'template'=>'quote_list',
            'params'=>['products'=>$products]
        ]);
    }

    private function _initQuoteItem()
    {
        $quote = $this->_initQuote();

        $product = $this->_di->get('Product',['data'=>[]]);
        $product->load($_POST['product_id'],'product_id');

        $item = $quote->getItems()->forProduct($product,$quote);
        return $item;
    }
}