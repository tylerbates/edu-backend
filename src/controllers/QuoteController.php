<?php
namespace App\Controller;

use App\Model\Quote;
use App\Model\QuoteItemCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Session;
use App\Model\Product;

class QuoteController extends Controller
{
    public function addAction()
    {
        $session = new Session();
        $resource = new DBEntity($this->_connection, new QuoteItemTable);
        $quoteItem = $this->_initQuoteItem();

        $quoteItem->addQty((int) $_POST['qty']);
        if($session->isAuthorized())
        {
            $quoteItem->save($resource);
        } else
        {
            $session->addProduct($quoteItem);
        }
        header('Location: /');
    }

    public function updateAction()
    {
        $quoteItem = $this->_initQuoteItem();

        $resource = new DBEntity($this->_connection, new QuoteItemTable);
        $quoteItem->updateQty($_POST['qty']);
        $quoteItem->save($resource);
        header('Location: /?page=quote_list');
    }

    public function deleteAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $resource = new DBEntity($this->_connection, new QuoteItemTable);
        $quoteItem->delete($resource);
        header('Location: /?page=quote_list');
    }

    public function listAction()
    {
        $quote = $this->_initQuote();
        $qi_collection_resource = new DBCollection($this->_connection, new QuoteItemTable);
        $quoteItems = new QuoteItemCollection($qi_collection_resource);
        $quoteItems->filterByQuote($quote);
        $product_resource = new DBEntity($this->_connection, new ProductTable);
        $products = $quoteItems->assignProducts(new Product([]),$product_resource);
        $view = 'quote_list';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    private function _initQuote()
    {
        $resource = new DBEntity($this->_connection,new QuoteItemTable);
        $quote = new Quote();
        $session = new Session();
        if($session->isAuthorized())
        {
            $quote->loadByCustomer($resource,$session->getUserId());
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
        $session = new Session();
        $product_resource = new DBEntity($this->_connection,new ProductTable);
        $product = new Product([]);
        $product->load($product_resource,$_POST['product_id']);

        $quoteItem = $quote->getItemForProduct($product, $session->getUserId(),(int) $_POST['link_id']);
        return $quoteItem;
    }
}