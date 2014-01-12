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

    public function __construct(array $data, IResourceEntity $resource, Smtp $transport, Customer $prototype)
    {
        $this->_transport = $transport;
        $this->_prototype = $prototype;
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
        <table border>
                <tr>
                    <td>Name</td><td>Sku</td><td>Quantity</td><td>Price</td><td>Summary</td>
                </tr>
        ";

        $table_footer = "
             </table>
        ";

        foreach ($items as $item)
        {
            $table_parts[] = "
                <tr>
                    <td>$item[0]</td><td>$item[1]</td><td>$item[2]</td><td>$item[3]</td><td>$item[4]</td>
                </tr>
            ";
        }

        array_unshift($table_parts,$table_header);
        array_push($table_parts,$table_footer);
        $table = implode($table_parts);
        return $table;
    }

    private function _prepareMessage()
    {
        $customer = clone $this->_prototype;
        $customer->load($this->_data['customer_id'], 'customer_id');
        if ($name = $customer->getName()) {
            $customer_data = $name;
        } else $customer_data = $this->_data['customer_id'];
        $num_order = rand(10000, 99999);
        $text = new MimePart("
            You have new order: {$num_order}\n
            Date: {$this->_data['created_at']}\n
            Customer: {$customer_data}\n
            Address: {$this->_data['address']}\n
            Shipping method: {$this->_data['shipping_method']}\n
            Payment method: {$this->_data['payment_method']}\n
            Products:\n
        ");
        $text->type = "text/plain";

        $totals_text = new MimePart("
            Totals:
            Subtotal: {$this->_data['subtotal']} Shipping: {$this->_data['shipping']}\n
            Grand Total: {$this->_data['grand_total']}\n
        ");
        $totals_text->type = "text/plain";

        $html = new MimePart($this->_prepareHtml());
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts([$text, $html, $totals_text]);
        return $body;
    }
} 