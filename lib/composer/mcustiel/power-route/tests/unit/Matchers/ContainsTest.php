<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Matchers\Contains;

class ContainsTest extends \PHPUnit_Framework_TestCase
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
        $this->matcher = new Contains();
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('potato', 'ot'));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertFalse($this->matcher->match('tomato', 'ot'));
    }
}
