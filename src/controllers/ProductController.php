<?php
namespace App\Controller;

use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;
use App\Model\ProductCollection;
use App\Model\ProductReviewCollection;
use App\Model\Product;
use App\Model\Resource\Paginator as PaginatorAdapter;
use Zend\Paginator\Paginator as ZendPaginator;

class ProductController extends Controller
{
    public function listAction()
    {
        $resource = new DBCollection($this->_connection,new ProductTable);
        $paginatorAdapter = new PaginatorAdapter($resource);
        $paginator = new ZendPaginator($paginatorAdapter);
        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();
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