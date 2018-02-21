<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Matchers\RegExp;

class RegExpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Matchers\MatcherInterface
     */
    private $matcher;

    private $argument = '/\d+/';

    /**
     * @before
     */
    public function setMatcher()
    {
        $this->matcher = new RegExp();
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('123456', $this->argument));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertTrue($this->matcher->match('123abc', $this->argument));
    }
}
