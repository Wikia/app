<?php

namespace Mcustiel\Tests\Fixtures;

class Dummy
{
    private $arg1;
    private $arg2;

    public function __construct($arg1, Dummy $arg2 = null)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }

    public function getArg1()
    {
        return $this->arg1;
    }

    public function getArg2()
    {
        return $this->arg2;
    }
}
