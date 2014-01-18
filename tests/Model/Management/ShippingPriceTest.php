<?php
namespace Test\Management;

use App\Model\Management\ShippingPrice;

class ShippingPriceTest extends \PHPUnit_Framework_TestCase
{
    public function testAddsNewRecord()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('rate_id'));

        $sh_price = new ShippingPrice([],$resource);
        $sh_price->add(['city'=>'foo','price'=>12]);
        $this->assertEquals('foo',$sh_price->getCity());
        $this->assertEquals(12,$sh_price->getPrice());
    }

    public function testUpdatesPriceIfRecordExists()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('rate_id'));

        $sh_price = new ShippingPrice(['city'=>'foo','price'=>12],$resource);
        $sh_price->add(['city'=>'foo','price'=>13]);

        $this->assertEquals('foo',$sh_price->getCity());
        $this->assertEquals(13,$sh_price->getPrice());
    }
}
 