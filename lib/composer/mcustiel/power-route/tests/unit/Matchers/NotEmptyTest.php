<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Matchers\NotEmpty;

class NotEmptyTest extends \PHPUnit_Framework_TestCase
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
        $this->matcher = new NotEmpty();
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('potato'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWithEmpty()
    {
        $this->assertFalse($this->matcher->match(''));
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
    public function shouldReturnFalseWithZero()
    {
        $this->assertFalse($this->matcher->match(0));
    }
}
