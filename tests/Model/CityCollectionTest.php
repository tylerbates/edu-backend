<?php
namespace Test\Model;
use App\Model\CityCollection;

class CityCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');

        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['city'=>'Rostov']
                ]
            ));

        $collection = new CityCollection($resource);
        $cities = $collection->getCities();
        $this->assertEquals('Rostov',$cities[0]->getCity());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['city' => 'Rostov'],
                    ['city' => 'Vologda']
                ]
            ));

        $collection = new CityCollection($resource);
        $cities = $collection->getCities();
        $expected = array(0 => 'Rostov', 1 => 'Vologda');
        $iterated = false;
        foreach ($cities as $_key => $_city) {
            $this->assertEquals($expected[$_key], $_city->getCity());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
}