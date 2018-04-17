<?php

namespace Mcustiel\PowerRoute\Matchers;

class Contains implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return strpos($value, $argument) !== false;
    }
}
