<?php
namespace App\Controller;

use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\DBConfig;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;
use App\Model\ProductCollection;
use App\Model\ProductReviewCollection;
use App\Model\Product;

class ProductController
{
    private $_connection;

    function __construct()
    {
        $this->_connection = DBConfig::connect();
    }

    function __destruct()
    {
        unset($this->_connection);
    }

    public function listAction()
    {
        $resource = new DBCollection($this->_connection,new ProductTable);
        $_products = new ProductCollection($resource);
        $products = $_products->getProducts();
        $view = 'product_list';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    public function viewAction()
    {
        $product = new Product([]);

        $resource = new DBEntity($this->_connection,new ProductTable);
        $product->load($resource,$_GET['id']);

        $resource = new DBCollection($this->_connection,new ReviewTable);
        $reviews = new ProductReviewCollection($resource);
        $reviews->filterByProduct($product);
        $_reviews = $reviews->getProductReviews();
        $average_rating = $reviews->getAverageRating();
        $view = 'product_view';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }
}