<?php
namespace App\Controller;


class ManageController extends Controller
{
    public function productAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            $prototype = $this->_di->get('Product',['data'=>[]]);
            $products = $this->_di->get('ProductCollection',['prototype'=>$prototype]);

            return $this->_di->get('View',[
                'template'=>'manage_product',
                'params'=>[
                    'products'=>$products
                ]
            ]);
        }
    }

    public function reviewAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_review'
            ]);
        }
    }

    public function customerAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_customer'
            ]);
        }
    }

    public function orderAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_order'
            ]);
        }
    }

    public function couponAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            return $this->_di->get('View',[
                'template'=>'manage_coupon'
            ]);
        }
    }

    public function shippingAction()
    {
        $session = $this->_di->get('Session');
        if(!$session->isAdmin())
        {
            $this->_redirect('product_list');
        }else
        {
            if(isset($_POST['shipping']))
            {
                $this->_addShipping($_POST['shipping']);
            }

            if(isset($_POST['delete_id']))
            {
                $this->_deleteShipping($_POST['delete_id']);
            }

            if(isset($_FILES['csv']))
            {
                $this->_loadFromCSV($_FILES['csv']);
            }

            $prototype = $this->_di->get('ShippingPrice',['data'=>[]]);
            $collection = $this->_di->get('ShippingPriceCollection',['prototype'=>$prototype]);

            if(isset($_POST['search_request']))
            {
                $collection->filter($_POST['search_request'],['city','price']);
            }

            if(isset($_POST['sort']))
            {
                $collection->sort($_POST['sort']['sort_field'],$_POST['sort']['sort_direction']);
            }
            $cities = $this->_di->get('CityCollection');
            return $this->_di->get('View',[
                'template'=>'manage_shipping',
                'params'=>[
                    'collection'=>$collection,
                    'cities'=>$cities
                ]
            ]);
        }
    }

    private function _addShipping($data)
    {
        $shipping = $this->_di->get('ShippingPrice',['data'=>$data]);
        $shipping->load($data['city'],'city');
        $shipping->add($data);
        $this->_redirect('manage_shipping');
    }

    private function _deleteShipping($id)
    {
        $shipping = $this->_di->get('ShippingPrice',['data'=>[]]);
        $shipping->load($id,'rate_id');
        $shipping->delete();
        $this->_redirect('manage_shipping');
    }

    private function _loadFromCSV($file)
    {
        $records =[];
        $upload_dir = '/vagrant/src/uploads/';
        $upload_file = $upload_dir . basename($file['name']);
        move_uploaded_file($file['tmp_name'],$upload_file);
        $handler = fopen($upload_file,"r");
        while(!feof($handler))
        {
            $data = fgetcsv($handler,null,';');
            $newrecord['city'] = $data[0];
            $newrecord['price'] = (float) $data[1];
            $records[] = $newrecord;
        }
        fclose($handler);
        unlink($upload_file);
        foreach($records as $record)
        {
            $this->_addShipping($record);
        }
        $this->_redirect('manage_shipping');
    }
} 