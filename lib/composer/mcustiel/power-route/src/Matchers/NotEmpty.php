<?php

namespace Mcustiel\PowerRoute\Matchers;

class NotEmpty implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return !empty($value);
    }
}
