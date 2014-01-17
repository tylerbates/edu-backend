<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;
use \Zend\Mail;
use \Zend\Mail\Transport\Smtp;
use \Zend\Mime\Part as MimePart;
use \Zend\Mime\Message as MimeMessage;

class Order extends Entity
{
    private $_transport;
    private $_prototype;
    private $_message;
    private $_template;

    public function __construct(
        array $data,
        IResourceEntity $resource,
        Smtp $transport,
        Customer $prototype,
        Mail\Message $message,
        ModelView $template
    )
    {
        $this->_transport = $transport;
        $this->_prototype = $prototype;
        $this->_message = $message;
        $this->_template = $template;
        parent::__construct($data,$resource);
    }

    public function setCustomerId($customer_id)
    {
        $this->_data['customer_id'] = $customer_id;
    }

    public function setShippingMethod($shippping_method)
    {
        $this->_data['shipping_method'] = $shippping_method;
    }

    public function setPaymentMethod($payment_method)
    {
        $this->_data['payment_method'] = $payment_method;
    }

    public function setAddress($address)
    {
        $this->_data['address'] = $address;
    }

    public function setItems($items)
    {
        $this->_data['items'] = $items;
    }

    public function setSubtotal($subtotal)
    {
        $this->_data['subtotal'] = $subtotal;
    }

    public function setShipping($shipping)
    {
        $this->_data['shipping'] = $shipping;
    }

    public function setGrandTotal($grand_total)
    {
        $this->_data['grand_total'] = $grand_total;
    }

    public function save()
    {
        date_default_timezone_set('Europe/Moscow');
        $this->_data['created_at'] = date("Y-m-d H:i:s");
        parent::save();
    }

    public function sendMail()
    {
        $body = $this->_prepareMessage();
        $this->_message->setBody($body);
        $this->_transport->send($this->_message);
    }

    private function _prepareMessage()
    {
        $customer = clone $this->_prototype;
        $customer->load($this->_data['customer_id'], 'customer_id');
        if ($name = $customer->getName()) {
            $customer_data = $name;
        } else $customer_data = $this->_data['customer_id'];

        $num_order = rand(10000, 99999);

        $items =[];
        $products = explode('|',$this->_data['items']);
        foreach($products as $product)
        {
            $items[] = explode(',',$product);
        }

        $this->_template->setParams([
            'customer'=>$customer_data,
            'num_order'=>$num_order,
            'data'=>$this->_data,
            'items'=>$items
        ]);

        ob_start();
        $this->_template->render();
        $body = ob_get_clean();

        $html = new MimePart($body);
        $html->type = "text/html";

        $m_body = new MimeMessage();
        $m_body->setParts([$html]);
        return $m_body;
    }
} 