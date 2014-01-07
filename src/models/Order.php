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

    public function __construct(array $data, IResourceEntity $resource, Smtp $transport)
    {
        $this->_transport = $transport;
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

    public function save()
    {
        date_default_timezone_set('Europe/Moscow');
        $this->_data['created_at'] = date("Y-m-d H:i:s");
        parent::save();
    }

    public function sendMail()
    {
        $text = new MimePart("
            You have new order:\n
            Customer id: {$this->_data['customer_id']}\n
            Address: {$this->_data['address']}\n
            Shipping method: {$this->_data['shipping_method']}\n
            Payment method: {$this->_data['payment_method']}\n
            Products:\n
        ");
        $text->type = "text/plain";

        $html = new MimePart($this->_prepareHtml());
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts([$text,$html]);

        $mail = new Mail\Message();
        $mail->setBody($body);
        $mail->addFrom('yourproductcatalog@gmail.com', 'your product catalog');
        $mail->addTo('tylerbates098@gmail.com','dear admin');
        $mail->setSubject('new order');

        $this->_transport->send($mail);
    }

    private function _prepareHtml()
    {
        $items =[];
        $products = explode('|',$this->_data['items']);
        foreach($products as $product)
        {
            $items[] = explode(',',$product);
        }

        $table_header = "
        <table border='solid'>
                <tr>
                    <td>Product id</td><td>Name</td><td>Quantity</td>
                </tr>
        ";

        $table_footer = "
             </table>
        ";

        foreach ($items as $item)
        {
            $table_parts[] = "
                <tr>
                    <td>$item[0]</td><td>$item[1]</td><td>$item[2]</td>
                </tr>
            ";
        }

        array_unshift($table_parts,$table_header);
        array_push($table_parts,$table_footer);
        $table = implode($table_parts);
        return $table;
    }
} 