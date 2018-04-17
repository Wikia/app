<?php

namespace Mcustiel\PowerRoute\Tests\Fixtures\Actions;

class MiddlewareAction implements Middleware
{
    public function __invoke($request, $response, $next = null)
    {
        return $response->withHeader('X-MIDDLEWARE-EXECUTED', 'Oh yeah!');
    }
}
