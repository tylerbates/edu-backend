<?php
namespace App\Controller;

use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use App\Model\Resource\Table\Product as ProductTable;

class QuoteController extends Controller
{
    public function addAction()
    {
        $session = $this->_di->get('Session');
        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->addQty((int) $_POST['qty']);
        $quoteItem->save($resource);
        if(!$session->isAuthorized())
        {
            $session->addQuoteItem($quoteItem->getId());
        }

        $this->_redirect('product_list');
    }

    public function updateAction()
    {
        $quoteItem = $this->_initQuoteItem();

        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quoteItem->updateQty($_POST['qty']);
        $quoteItem->save($resource);
        $this->_redirect('quote_list');
    }

    public function deleteAction()
    {
        $session = $this->_di->get('Session');
        $quoteItem = $this->_initQuoteItem();
        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quoteItem->delete($resource);
        if(!$session->isAuthorized())
        {
            $session->deleteQuoteItem($quoteItem->getId());
        }
        $this->_redirect('quote_list');
    }

    public function listAction()
    {
        $quote = $this->_initQuote();
        $quoteItems = $this->_di->get('QuoteCollection');
        $quoteItems->filterByQuote($quote);

        $prototype = $this->_di->get('Product',['data'=>[]]);
        $products = $quoteItems->assignProducts($prototype);

        return $this->_di->get('View',[
            'template'=>'quote_list',
            'params'=>['products'=>$products]
        ]);
    }

    private function _initQuote()
    {
        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quote =$this->_di->get('Quote',['resource'=>$resource]);
        $session = $this->_di->get('Session');
        if($session->isAuthorized())
        {
            $quote->loadByCustomer($session->getUserId());
            return $quote;
        } else
        {
            $quote->loadBySession($session);
            return $quote;
        }
    }

    private function _initQuoteItem()
    {
        $quote = $this->_initQuote();
        $session = $this->_di->get('Session');

        $product = $this->_di->get('Product',['data'=>[]]);

        $product->load($_POST['product_id'],(new ProductTable())->getPrimaryKey());

        $quoteItem = $quote->getItemForProduct($product, $session->getUserId(),(int) $_POST['link_id']);
        return $quoteItem;
    }
}