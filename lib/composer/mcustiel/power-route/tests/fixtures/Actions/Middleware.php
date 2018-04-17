<?php

namespace Mcustiel\PowerRoute\Tests\Fixtures\Actions;

interface Middleware
{
    public function __invoke($request, $response, $next = null);
}
