<?php
namespace Test\Model;

use App\Model\Customer;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testSavesDataInDB()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
                 ->method('save')
                 ->with($this->equalTo(['name' => 'Vasia']));
        $customer = new Customer(['name' => 'Vasia'],$resource);

        $customer->save($resource);
    }

    public function testReturnsIdWhichHasBeenInitialized()
    {
        $customer = new Customer(['customer_id' => 1]);
        $this->assertEquals(1,$customer->getId());

        $customer = new Customer(['customer_id' => 2]);
        $this->assertEquals(2,$customer->getId());
    }

    public function  testReturnsIdAfterSave()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['name' => 'Vasia']))
            ->will($this->returnValue(24));
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('customer_id'));

        $customer = new Customer(['name' => 'Vasia'],$resource);
        $customer->save($resource);

        $this->assertEquals(24,$customer->getId());
    }
}