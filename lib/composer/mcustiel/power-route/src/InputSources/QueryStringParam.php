<?php

namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;

class QueryStringParam implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request, $argument = null)
    {
        $array = $request->getQueryParams();

        return isset($array[$argument]) ? $array[$argument] : null;
    }
}
