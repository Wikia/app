<?php
namespace Integration;

use Mcustiel\SimpleRequest\FirstErrorRequestParser;
use Mcustiel\SimpleRequest\Strategies\PropertyParserBuilder;
use Mcustiel\SimpleRequest\Interfaces\ValidatorInterface;
use Mcustiel\SimpleRequest\Exception\InvalidValueException;
use Fixtures\PersonRequest;
use Mcustiel\SimpleRequest\RequestBuilder;

class FirstErrorRequestParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\SimpleRequest\FirstErrorRequestParser
     */
    private $requestParser;
    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    /**
     * @before
     */
    public function prepare()
    {
        $this->validator = $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestParser = new FirstErrorRequestParser();
    }

    /**
     * @test
     * @expectedException Mcustiel\SimpleRequest\Exception\InvalidRequestException
     * @expectedExceptionRegExp /^firstName\:/
     */
    public function shouldFailIfTheValidatorFails()
    {
        $this->validator->expects($this->once())
            ->method('validate')
            ->with('Tomato')
            ->will($this->throwException(new InvalidValueException()));
        $this->requestParser->addPropertyParser(
            (new PropertyParserBuilder('firstName'))
            ->addValidator($this->validator)
            ->build(
                $this->getMockBuilder(RequestBuilder::class)
                ->disableOriginalConstructor()
                ->getMock()
            )
        );
        $this->requestParser->setRequestObject(new PersonRequest());
        $this->requestParser->parse(['firstName' => 'Tomato']);
    }
}
