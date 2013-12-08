<?php
namespace Test\Model;

use App\Model\Basket;

class BasketTest extends \PHPUnit_Framework_TestCase
{
    public function testSavesProductToBasket()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['name' => 'Vasia']));
        $basket = new Basket(['name' => 'Vasia']);

        $basket->create($resource);
    }
}