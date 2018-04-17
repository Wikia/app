<?php

namespace Integration\Util;

use Mcustiel\SimpleRequest\Util\ValidatorBuilder;
use Mcustiel\SimpleRequest\Filter\Capitalize;

class ValidatorBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\ValidatorDoesNotExistException
     * @expectedExceptionMessage Validator class potato does not exist
     */
    public function buildFailsWhenTheClassIsInvalid()
    {
        ValidatorBuilder::builder()
            ->withClass('potato')
            ->build();
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\ValidatorDoesNotExistException
     * @expectedExceptionMessage Validator class Mcustiel\SimpleRequest\Filter\Capitalize must implement Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     */
    public function buildFailsWhenTheClassIsNotAValidator()
    {
        ValidatorBuilder::builder()
            ->withClass(Capitalize::class)
            ->build();
    }
}
