<?php
namespace App\Model;

use Zend\Di\Di;

class DiC
{
    private $_di;
    private $_im;

    public function __construct(Di $di)
    {
        $this->_di = $di;
        $this->_im = $di->instanceManager();
    }

    public function assemble()
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $_method) {
            if (strpos($_method->getName(), '_assemble') === 0) {
                $_method->setAccessible(true);
                $_method->invoke($this);
            }
        }
    }

    private function _assembleDbConnection()
    {
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123qweasdzxc');
        $this->_im->setParameters('App\Model\Resource\DBCollection', ['connection' => $connection]);
        $this->_im->setParameters('App\Model\Resource\DBEntity', ['connection' => $connection]);
    }

    private function _assembleResources()
    {
        $this->_im->addTypePreference('App\Model\Resource\IResourceCollection', 'App\Model\Resource\DBCollection');
        $this->_im->addTypePreference('App\Model\Resource\IResourceEntity', 'App\Model\Resource\DBEntity');
        $this->_im->addAlias('ResourceCollection', 'App\Model\Resource\DBCollection');
        $this->_im->addAlias('ResourceEntity', 'App\Model\Resource\DBEntity');

        $this->_im->setShared('App\Model\Resource\DBEntity', false);
        $this->_im->setShared('App\Model\Resource\DBCollection', false);
    }

    private function _assemblePaginator()
    {
        $this->_im->setParameters('Zend\Paginator\Paginator', ['adapter' => 'App\Model\Resource\Paginator']);
        $this->_im->addAlias('Paginator', 'Zend\Paginator\Paginator');
    }

    private function _assembleProduct()
    {
        $this->_im->setParameters('App\Model\ProductCollection', ['table' => 'App\Model\Resource\Table\Product']);
        $this->_im->addAlias('ProductCollection', 'App\Model\ProductCollection');

        $this->_im->setParameters('App\Model\Product', ['table' => 'App\Model\Resource\Table\Product']);
        $this->_im->addAlias('Product', 'App\Model\Product');
    }

    private function _assembleReview()
    {
        $this->_im->setParameters('App\Model\ProductReviewCollection', ['table' => 'App\Model\Resource\Table\Review']);
        $this->_im->addAlias('ReviewCollection', 'App\Model\ProductReviewCollection');

        $this->_im->setParameters('App\Model\ProductReview', ['table' => 'App\Model\Resource\Table\Review']);
        $this->_im->addAlias('Review', 'App\Model\ProductReview');
    }

    private function _assembleCustomer()
    {
        $this->_im->setParameters('App\Model\Customer', ['table' => 'App\Model\Resource\Table\Customer']);
        $this->_im->addAlias('Customer', 'App\Model\Customer');
    }

    private function _assembleAdmin()
    {
        $this->_im->setParameters('App\Model\Admin', ['table' => 'App\Model\Resource\Table\Admin']);
        $this->_im->addAlias('Admin', 'App\Model\Admin');
    }

    private function _assembleSmtp()
    {
        $this->_im->setParameters('Zend\Mail\Transport\SmtpOptions',[
            'options'=>[
                'name'=>'yourproductcatalog.com',
                'host'=>'smtp.gmail.com',
                'connection_class' => 'login',
                'port'=>'465',
                'connection_config'=>[
                    'ssl'=>'ssl',
                    'username' => 'yourproductcatalog@gmail.com',
                    'password' => 'sdfgpoiu123'
                ]
            ]
        ]);

        $this->_im->addAlias('SmtpOptions','Zend\Mail\Transport\SmtpOptions');

        $this->_im->setParameters('Zend\Mail\Transport\Smtp',[
            'options'=>$this->_di->get('SmtpOptions')
        ]);
        $this->_im->addAlias('SmtpTransport','Zend\Mail\Transport\Smtp');
    }

    private function _assembleView()
    {
        $this->_im->setParameters('App\Model\ModelView', [
            'layoutDir'   => __DIR__ . '/../views/layout/',
            'templateDir' => __DIR__ . '/../views/',
            'layout'      => 'base',
            'params'      => [],
        ]);
        $this->_im->addAlias('View', 'App\Model\ModelView');
    }

    private function _assembleOrder()
    {
        $message = $this->_di->get('Zend\Mail\Message');
        $message->addFrom('yourproductcatalog@gmail.com', 'your product catalog');
        $message->addTo('tylerbates098@gmail.com','dear admin');
        $message->setSubject('new order');
        $this->_im->setParameters('App\Model\Order', [
            'table'=>'App\Model\Resource\Table\Order',
            'transport'=>$this->_di->get('SmtpTransport'),
            'prototype'=>$this->_di->get('Customer',['data'=>[]]),
            'message'=>$message,
            'template'=>$this->_di->get('View',[
                    'layout'=>'message_base',
                    'template'=>'message'
                ])
        ]);
        $this->_im->addAlias('Order','App\Model\Order');
    }

    private function _assembleManagement()
    {
        $this->_im->setParameters('App\Model\Management\ShippingPrice',['table'=>'App\Model\Resource\Table\ShippingRate']);
        $this->_im->addAlias('ShippingPrice','App\Model\Management\ShippingPrice');

        $this->_im->setParameters('App\Model\Management\ShippingPriceCollection',['table'=>'App\Model\Resource\Table\ShippingRate']);
        $this->_im->addAlias('ShippingPriceCollection','App\Model\Management\ShippingPriceCollection');
    }

    private function _assembleAddress()
    {
        $this->_im->setParameters('App\Model\Address', ['table' => 'App\Model\Resource\Table\Address', 'data'=>[]]);
        $this->_im->addAlias('Address', 'App\Model\Address');

        $this->_im->setParameters('App\Model\City', ['table' => 'App\Model\Resource\Table\City']);
        $this->_im->addAlias('City', 'App\Model\City');

        $this->_im->setParameters('App\Model\CityCollection', ['table' => 'App\Model\Resource\Table\City']);
        $this->_im->addAlias('CityCollection', 'App\Model\CityCollection');

        $this->_im->setParameters('App\Model\Region', ['table' => 'App\Model\Resource\Table\Region']);
        $this->_im->addAlias('Region', 'App\Model\Region');

        $this->_im->setParameters('App\Model\RegionCollection', ['table' => 'App\Model\Resource\Table\Region']);
        $this->_im->addAlias('RegionCollection', 'App\Model\RegionCollection');
    }

    private function _assembleFactory()
    {
        $this->_im->setParameters('App\Model\Shipping\Factory',['table'=>'App\Model\Resource\Table\ShippingRate']);
        $this->_im->addAlias('ShippingFactory','App\Model\Shipping\Factory');

        $this->_im->setParameters('App\Model\Payment\Factory',['table'=>'App\Model\Resource\Table\ShippingRate']);
        $this->_im->addAlias('PaymentFactory','App\Model\Payment\Factory');

        $this->_im->setParameters('App\Model\Quote\CollectorsFactory',[
            'prototype'=>$this->_di->get('Product',['data'=>[]]),
            'factory'=>$this->_di->get('ShippingFactory')
        ]);

        $this->_im->setParameters('App\Model\Quote\ConverterFactory',[
            'prototype'=>$this->_di->get('Product',['data'=>[]])
        ]);
    }

    private function _assembleConverter()
    {
        $this->_im->setParameters('App\Model\Quote\Converter',['factory'=>'App\Model\Quote\ConverterFactory']);
        $this->_im->addAlias('QuoteConverter','App\Model\Quote\Converter');
    }

    private function _assembleQuote()
    {
        $this->_im->setParameters('App\Model\QuoteItem', ['table' => 'App\Model\Resource\Table\QuoteItem' , 'data'=>[]]);
        $this->_im->addAlias('QuoteItem', 'App\Model\QuoteItem');

        $this->_im->setParameters('App\Model\QuoteItemCollection', [
            'table' => 'App\Model\Resource\Table\QuoteItem',
            'itemPrototype' => 'App\Model\QuoteItem'
        ]);
        $this->_im->addAlias('QuoteItemCollection', 'App\Model\QuoteItemCollection');

        $this->_im->setParameters('App\Model\Quote', [
            'table' => 'App\Model\Resource\Table\Quote',
            'items'=>$this->_di->get('App\Model\QuoteItemCollection'),
            'address'=>$this->_di->get('Address'),
            'collectorsFactory'=>$this->_di->get('App\Model\Quote\CollectorsFactory')
        ]);
        $this->_im->addAlias('Quote', 'App\Model\Quote');
    }

    private function _assembleSession()
    {
        $this->_im->addAlias('Session','App\Model\Session');
        $this->_im->setParameters('App\Model\ISessionUser', ['session'=>$this->_di->get('Session')]);
    }
}