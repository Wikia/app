<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Matchers\InArray;

class InArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Matchers\MatcherInterface
     */
    private $matcher;

    private $argument = ['tomato' => 'potato'];

    /**
     * @before
     */
    public function setMatcher()
    {
        $this->matcher = new InArray();
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('potato', $this->argument));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertFalse($this->matcher->match('tomato', $this->argument));
    }
}
