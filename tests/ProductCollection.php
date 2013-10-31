<?php
require_once __DIR__ . '/../src/ProductCollection.php';

$products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])]);
if (assert($products->getProducts() == [new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])],'Returns products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku'=>'bar']),new Product(['sku'=>'foo'])]);
if (assert($products->getProducts() == [new Product(['sku'=>'bar']),new Product(['sku'=>'foo'])],'Returns products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product([]),new Product([])]);
if (assert($products->getSize() == 2,'Returns number of products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product([])]);
if (assert($products->getSize() == 1,'Returns number of products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])]);
$products->limit(1);
if (assert($products->getProducts() == [new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])] && $products->getSize() == 1,'Returns limited products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])]);
$products->limit(2);
if (assert($products->getProducts() == [new Product(['sku'=>'foo']),new Product(['sku'=>'bar'])] && $products->getSize() == 2,'Returns limited products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);
$products->offset(0);
if (assert($products->getProducts() == [new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])],'Returns offset products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);
$products->offset(1);
if (assert($products->getProducts() == [new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])],'Returns products which have been initialized')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku'=>'foo']),new Product(['sku'=>'bar']),new Product(['sku'=>'baz'])]);
$products->offset(2);
if (assert($products->getProducts() == [new Product(['sku'=>'baz'])],'Returns products which have been initialized')) {
    echo '.';
}

echo "\n";