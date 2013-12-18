<?php
namespace Test\Model;

use App\Model\Region;

class RegionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(['id'=>42]))
            ->will($this->returnValue(['region' => 'Rostov obl']));

        $region = new Region([], $resource);
        $region->load(42, 'id');

        $this->assertEquals('Rostov obl', $region->getRegion());
    }
}