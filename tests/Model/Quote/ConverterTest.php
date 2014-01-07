<?php
namespace Test\Model\Quote;

use App\Model\Order;
use App\Model\Quote;
use App\Model\Quote\Converter;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertsQuoteToOrderUsingConverters()
    {
        $quote = new Quote();
        $order = $this->getMockBuilder('App\Model\Order')
            ->disableOriginalConstructor()
            ->getMock();

        $partConverter = $this->getMock('App\Model\Quote\IConverter');
        $partConverter->expects($this->once())
            ->method('toOrder')
            ->with($this->equalTo($quote),$this->equalTo($order));

        $converterFactory = $this->getMock('App\Model\Quote\ConverterFactory');
        $converterFactory->expects($this->once())
            ->method('getConverters')
            ->will($this->returnValue([$partConverter]));

        $converter = new Converter($converterFactory);

        $converter->toOrder($quote,$order);
    }
}