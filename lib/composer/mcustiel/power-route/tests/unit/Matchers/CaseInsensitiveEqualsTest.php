<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Matchers\CaseInsensitiveEquals;

class CaseInsensitiveEqualsTest extends \PHPUnit_Framework_TestCase
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
        $this->matcher = new CaseInsensitiveEquals();
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('PoTaTo', 'pOtAtO'));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertFalse($this->matcher->match('PoTaTo', 'tomato'));
    }
}
