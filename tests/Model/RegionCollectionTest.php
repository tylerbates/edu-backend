<?php
namespace Test\Model;
use App\Model\RegionCollection;

class RegionCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');

        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name'=>'Rostov obl']
                ]
            ));

        $collection = new RegionCollection($resource);
        $regions = $collection->getRegions();
        $this->assertEquals('Rostov obl',$regions[0]->getRegion());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Rostov obl'],
                    ['name' => 'Vologda obl']
                ]
            ));

        $collection = new RegionCollection($resource);
        $regions = $collection->getRegions();
        $expected = array(0 => 'Rostov obl', 1 => 'Vologda obl');
        $iterated = false;
        foreach ($regions as $_key => $_region) {
            $this->assertEquals($expected[$_key], $_region->getRegion());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
}