<?php
namespace Integration;

use Mcustiel\SimpleRequest\AllErrorsRequestParser;
use Mcustiel\SimpleRequest\Strategies\PropertyParserBuilder;
use Mcustiel\SimpleRequest\Interfaces\ValidatorInterface;
use Mcustiel\SimpleRequest\Exception\InvalidValueException;
use Fixtures\PersonRequest;
use Mcustiel\SimpleRequest\RequestBuilder;

class AllErrorsRequestParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\SimpleRequest\AllErrorsRequestParser
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
        $this->requestParser = new AllErrorsRequestParser();
    }

    /**
     * @test
     * @expectedException Mcustiel\SimpleRequest\Exception\InvalidRequestException
     * @expectedExceptionMessage Errors occurred while parsing the request
     */
    public function shouldFailIfAValidatorFails()
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
