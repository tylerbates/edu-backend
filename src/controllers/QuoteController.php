<?php
namespace App\Controller;

use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Session;

class QuoteController extends Controller
{
    public function addAction()
    {
        $session = new Session();
        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->addQty((int) $_POST['qty']);
        $quoteItem->save($resource);
        if(!$session->isAuthorized())
        {
            $session->addQuoteItem($quoteItem->getId());
        }


        header('Location: /');
    }

    public function updateAction()
    {
        $quoteItem = $this->_initQuoteItem();

        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quoteItem->updateQty($_POST['qty']);
        $quoteItem->save($resource);
        header('Location: /?page=quote_list');
    }

    public function deleteAction()
    {
        $session = new Session();
        $quoteItem = $this->_initQuoteItem();
        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable()]);
        $quoteItem->delete($resource);
        if(!$session->isAuthorized())
        {
            $session->deleteQuoteItem($quoteItem->getId());
        }
        header('Location: /?page=quote_list');
    }

    public function listAction()
    {
        $quote = $this->_initQuote();
        $qi_collection_resource = $this->_di->get('ResourceCollection', ['table' => new QuoteItemTable()]);
        $quoteItems = $this->_di->get('QuoteCollection',['resource'=>$qi_collection_resource]);
        $quoteItems->filterByQuote($quote);
        $product_resource = $this->_di->get('ResourceEntity', ['table' => new ProductTable()]);
        $prototype = $this->_di->get('Product',['resource' => $product_resource,'data'=>[]]);
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
        $session = new Session();
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
        $session = new Session();

        $product_resource = $this->_di->get('ResourceEntity', ['table' => new ProductTable()]);
        $product = $this->_di->get('Product',['resource' => $product_resource,'data'=>[]]);

        $product->load($_POST['product_id'],(new ProductTable())->getPrimaryKey());

        $quoteItem = $quote->getItemForProduct($product, $session->getUserId(),(int) $_POST['link_id']);
        return $quoteItem;
    }
}