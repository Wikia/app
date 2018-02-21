<?php

namespace Mcustiel\PowerRoute\Common\Conditions;

use Psr\Http\Message\ServerRequestInterface;

interface ConditionsMatcherInterface
{
    public function matches(array $conditions, ServerRequestInterface $request);
}
