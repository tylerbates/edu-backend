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
        //var_dump($quoteItem);die;
        $quoteItem->delete();
        $this->_redirect('quote_list');
    }

    public function listAction()
    {
        $quote = $this->_initQuote();
        $quoteItems = $this->_di->get('QuoteItemCollection');
        $quoteItems->filterByQuote($quote);

        $pr_resource = $this->_di->get('ResourceEntity',['table'=>new ProductTable()]);
        $prototype = $this->_di->get('Product',['resource'=>$pr_resource,'data'=>[]]);

        $products = $quoteItems->assignProducts($prototype);
        return $this->_di->get('View',[
            'template'=>'quote_list',
            'params'=>['products'=>$products]
        ]);
    }

    private function _initQuoteItem()
    {
        $quote = $this->_initQuote();
        $pr_resource = $this->_di->get('ResourceEntity',['table'=>new ProductTable()]);
        $product = $this->_di->get('Product',['resource'=>$pr_resource,'data'=>[]]);
        $product->load($_POST['product_id'],'product_id');
        $qi_resource = $this->_di->get('ResourceEntity',['table'=>new QuoteItemTable()]);
        $prototype = $this->_di->get('QuoteItem',['resource'=>$qi_resource,'data'=>[]]);
        $item = $quote->getItemForProduct($prototype, $product,$_POST['link_id']);
        return $item;
    }
}