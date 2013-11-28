<?php
require_once __DIR__ . '/../src/models/ProductCollection.php';

class __ProductCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsProductsWhichHaveBeenInitialized()
    {
        $products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])]);
        $this->assertEquals([new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])],$products->getProducts());

        $products = new ProductCollection([new Product(['sku'=>'bar']),new Product(['sku'=>'foo'])]);
        $this->assertEquals([new Product(['sku'=>'bar']),new Product(['sku'=>'foo'])],$products->getProducts());
    }

    public function testCalculatesCollectionSizeAsProductsCount()
    {
        $products = new ProductCollection([new Product([]),new Product([])]);
        $this->assertEquals(2,$products->getSize());

        $products = new ProductCollection([new Product([])]);
        $this->assertEquals(1,$products->getSize());
    }

    public function testAppliesLimitToProductCollectionSize()
    {
        $products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])]);

        $products->limit(1);
        $this->assertEquals(1,$products->getSize());

        $products->limit(3);
        $this->assertEquals(2,$products->getSize());

        $products->limit(0);
        $this->assertEquals(0,$products->getSize());
    }

    public function testAppliesLimitToCollectionProducts()
    {
        $products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);

        $products->limit(1);
        $this->assertEquals([new Product(['sku'=>'foo'])],$products->getProducts());

        $products->limit(4);
        $this->assertEquals([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])],$products->getProducts());

        $products->limit(0);
        $this->assertEquals([],$products->getProducts());
    }

    public function testAppliesOffsetToCollectionProducts()
    {
        $products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);

        $products->offset(1);
        $this->assertEquals([new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])],$products->getProducts());

        $products->offset(4);
        $this->assertEquals([],$products->getProducts());

        $products->offset(0);
        $this->assertEquals([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])],$products->getProducts());
    }

    public function testAppliesOffsetToCollectionSize()
    {
        $products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);

        $products->offset(1);
        $this->assertEquals(2,$products->getSize());

        $products->offset(4);
        $this->assertEquals(0,$products->getSize());
    }

    public function testAppliesSortingToCollectionProducts()
    {
        $products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);
        $products->sort('sku');

        $this->assertEquals([new Product(['sku'=>'bar']),new Product(['sku'=>'baz']),new Product(['sku'=>'foo'])],$products->getProducts());

        $products = new ProductCollection([new Product(['sku'=>'baz']),new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])]);
        $products->sort('sku');

        $this->assertEquals([new Product(['sku'=>'bar']),new Product(['sku'=>'baz']),new Product(['sku'=>'foo'])],$products->getProducts());
    }

    public function testIsIterableWithForeachFunction()
    {
        $collection = new ProductCollection(
            [new Product(['name' => 'foo']), new Product(['name' => 'bar'])]
        );
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($collection as $_key => $_product) {
            $this->assertEquals($expected[$_key], $_product->getName());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
}