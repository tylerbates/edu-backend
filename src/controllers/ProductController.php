<?php
namespace App\Controller;

use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;

class ProductController extends Controller
{
    public function listAction()
    {
        $resource = $this->_di->get('ResourceCollection',['table'=>new ProductTable()]);
        $paginator = $this->_di->get('Paginator',['collection'=>$resource]);
        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();
        $prototype = $this->_di->get('Product',['data'=>[]]);
        $products = $this->_di->get('ProductCollection',['resource'=>$resource,'prototype'=>$prototype]);

        return $this->_di->get('View',[
            'template'=>'product_list',
            'params'=>['products'=>$products, 'pages'=>$pages]
        ]);
    }

    public function viewAction()
    {
        $resource = $this->_di->get('ResourceCollection',['table'=>new ReviewTable()]);

        $this->_di->get('Session')->generateToken();
        $product = $this->_di->get('Product',['data'=>[]]);
        $product->load($_GET['id'],(new ProductTable())->getPrimaryKey());

        $prototype = $this->_di->get('Review',['data'=>[]]);
        $reviews = $this->_di->get('ReviewCollection',['resource'=>$resource,'prototype'=>$prototype]);
        $reviews->filterByProduct($product);

///////////I had to do that because of magick replacement of collection with average rating results///////////////
        $reviewsForAverage = $this->_di->get('ReviewCollection',['prototype'=>$prototype]);
        $reviewsForAverage->filterByProduct($product);
        $average_rating = $reviewsForAverage->getAverageRating();
///////////I had to do that because of magick replacement of collection with average rating results///////////////

        $paginator = $this->_di->get('Paginator',['collection'=>$resource]);
        $paginator
            ->setItemCountPerPage(3)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();

        return $this->_di->get('View',[
            'template'=>'product_view',
            'params'=>[
                'product'=>$product,
                'rating'=>$average_rating,
                'reviews'=>$reviews,
                'pages'=>$pages
            ]
        ]);
    }
}