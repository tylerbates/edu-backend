<?php
namespace Test\Model;
use App\Model\Product;
use App\Model\ProductCollection;

class ProductCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');

        $resource->expects($this->any())
                 ->method('fetch')
                 ->will($this->returnValue(
                [
                    ['name'=>'Nokla']
                ]
            ));
        $product = new Product([]);
        $collection = new ProductCollection($resource,$product);
        $products = $collection->getProducts();
        $this->assertEquals('Nokla',$products[0]->getName());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['sku' => 'foo'],
                    ['sku' => 'bar']
                ]
            ));
        $product = new Product([]);
        $collection = new ProductCollection($resource, $product);
        $products = $collection->getProducts();
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($products as $_key => $_product) {
            $this->assertEquals($expected[$_key], $_product->getSku());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
}