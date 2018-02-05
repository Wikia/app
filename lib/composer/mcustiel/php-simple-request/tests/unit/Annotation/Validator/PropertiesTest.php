<?php
namespace Unit\Annotation\Validator;

use Mcustiel\SimpleRequest\Annotation\Validator\Properties;

class PropertiesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @expectedException \Mcustiel\SimpleRequest\Exception\InvalidAnnotationException
     * @expectedExceptionMessage Properties field must specify a set of (name, validator) pairs
     */
    public function failWhenNumberOfArgumentsIsInvalid()
    {
        $properties = new Properties();
        $properties->properties = ["We're", 'three', 'args'];
        $properties->getValue();
    }
}
