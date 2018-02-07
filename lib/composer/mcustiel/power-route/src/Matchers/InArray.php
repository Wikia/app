<?php

namespace Mcustiel\PowerRoute\Matchers;

class InArray implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return in_array($value, $argument, true);
    }
}
