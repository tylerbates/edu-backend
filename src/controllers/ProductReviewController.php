<?php
namespace App\Controller;

class ProductReviewController
    extends Controller
{
    public function addAction()
    {
        if($this->_validRequest())
        {
            $data = $_POST;
            unset($data['review_id']);
            unset($data['token']);

            $review = $this->_di->get('Review', ['data' => $data]);
            $review->save();
            $this->_redirect('product_view', ['id' => $data['product_id']]);
        } else
        {
            $this->_redirect('product_list');
        }
    }

    private function _validRequest()
    {
        return isset($_POST['token']) && $this->_di->get('Session')->validateToken($_POST['token']);
    }
}
