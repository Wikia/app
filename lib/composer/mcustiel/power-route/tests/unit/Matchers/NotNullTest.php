<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Matchers\NotNull;

class NotNullTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Matchers\MatcherInterface
     */
    private $matcher;

    /**
     * @before
     */
    public function setMatcher()
    {
        $this->matcher = new NotNull();
    }

    /**
     * @test
     */
    public function shouldReturnTrueWithString()
    {
        $this->assertTrue($this->matcher->match('potato'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWithEmpty()
    {
        $this->assertTrue($this->matcher->match(''));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWithNull()
    {
        $this->assertFalse($this->matcher->match(null));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWithZero()
    {
        $this->assertTrue($this->matcher->match(0));
    }
}
