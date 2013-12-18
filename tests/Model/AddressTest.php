<?php
namespace Test\Model;

use App\Model\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsDataFieldsWhichHvaBeenInitialized()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['city' => 'Rostov']));

        $address = new Address(['city' => 'Rostov'], $resource);
        $address->save();
    }

    public function testReturnsFieldsWhichHaveBeenInitialized()
    {
        $address = new Address(['city' => 'Rostov']);
        $this->assertEquals('Rostov',$address->getCity());

        $address = new Address(['city' => 'Vologda']);
        $this->assertEquals('Vologda',$address->getCity());

        $address = new Address(['region' => 'Moskow obl.']);
        $this->assertEquals('Moskow obl.',$address->getRegion());

        $address = new Address(['region' => 'Rostov obl.']);
        $this->assertEquals('Rostov obl.',$address->getRegion());

        $address = new Address(['mail_index' => 414056]);
        $this->assertEquals(414056,$address->getMailIndex());

        $address = new Address(['mail_index' => 414057]);
        $this->assertEquals(414057,$address->getMailIndex());

        $address = new Address(['street' => 'Volodyanovsakaya']);
        $this->assertEquals('Volodyanovsakaya',$address->getStreet());

        $address = new Address(['street' => 'Vodyanovsakaya']);
        $this->assertEquals('Vodyanovsakaya',$address->getStreet());

        $address = new Address(['flat' => '41']);
        $this->assertEquals('41',$address->getFlat());

        $address = new Address(['flat' => '41b']);
        $this->assertEquals('41b',$address->getFlat());
    }
}