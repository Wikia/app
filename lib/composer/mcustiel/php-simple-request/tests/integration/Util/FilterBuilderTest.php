<?php

namespace Integration\Util;

use Mcustiel\SimpleRequest\Util\FilterBuilder;
use Mcustiel\SimpleRequest\Validator\Minimum;

class FilterBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\FilterDoesNotExistException
     * @expectedExceptionMessage Filter class potato does not exist
     */
    public function buildFailsWhenTheClassIsInvalid()
    {
        FilterBuilder::builder()
            ->withClass('potato')
            ->build();
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\FilterDoesNotExistException
     * @expectedExceptionMessage Filter class Mcustiel\SimpleRequest\Validator\Minimum must implement Mcustiel\SimpleRequest\Interfaces\FilterInterface
     */
    public function buildFailsWhenTheClassIsNotAFilter()
    {
        FilterBuilder::builder()
            ->withClass(Minimum::class)
            ->build();
    }
}
