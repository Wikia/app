<?php

namespace Mcustiel\PowerRoute\Matchers;

class Equals implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return $value === $argument;
    }
}
