<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\Customer;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsProductTableName()
    {
        $table = new Customer;
        $this->assertEquals('customers',$table->getName());
    }

    public function testReturnsProductPrimaryKey()
    {
        $table = new Customer;
        $this->assertEquals('customer_id',$table->getPrimaryKey());
    }
}