<?php
namespace Unit\Strategies;

use Mcustiel\SimpleRequest\Strategies\AnnotationParserFactory;
use Mcustiel\SimpleRequest\Annotation\ParseAs;
use Mcustiel\SimpleRequest\Strategies\Annotations\ParseAsAnnotationParser;
use Fixtures\FakeAnnotation;

class AnnotationParserFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\SimpleRequest\Strategies\AnnotationParserFactory
     */
    private $factory;

    /**
     * @before
     */
    public function prepare()
    {
        $this->factory = new AnnotationParserFactory();
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Unsupported annotation: Fixtures\FakeAnnotation
     */
    public function failIfAnnotationIsInvalid()
    {
        $this->factory->getAnnotationParserFor(new FakeAnnotation());
    }

    /**
     * @test
     */
    public function returnParseAsParserForParseAsAnnotation()
    {
        $parser = $this->factory->getAnnotationParserFor(new ParseAs());
        $this->assertInstanceOf(ParseAsAnnotationParser::class, $parser);
    }
}
