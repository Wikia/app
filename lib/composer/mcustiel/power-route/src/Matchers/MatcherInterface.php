<?php

namespace Mcustiel\PowerRoute\Matchers;

interface MatcherInterface
{
    /**
     * @param mixed $value
     * @param mixed $argument
     *
     * @return bool
     */
    public function match($value, $argument = null);
}
