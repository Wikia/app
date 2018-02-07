<?php

namespace Mcustiel\PowerRoute\Matchers;

class CaseInsensitiveEquals implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return strtolower($value) === strtolower($argument);
    }
}
