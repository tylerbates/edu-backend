<?php
namespace Test\Model;

use App\Model\City;

class CityTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(['id'=>42]))
            ->will($this->returnValue(['city' => 'Rostov']));

        $city = new City([], $resource);
        $city->load(42, 'id');

        $this->assertEquals('Rostov', $city->getCity());
    }
}