<?php
namespace App\Model\Quote;


use App\Model\Product;

class ConverterFactory
{
    private $_prototype;

    public function __construct(Product $prototype)
    {
        $this->_prototype = $prototype;
    }

    public function getConverters()
    {
        return [
            new DataConverter(),
            new AddressConverter(),
            new ItemsConverter($this->_prototype)
        ];
    }
} 