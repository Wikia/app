<?php

namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;

class Cookie implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request, $argument = null)
    {
        $array = $request->getCookieParams();

        return isset($array[$argument]) ? $array[$argument] : null;
    }
}
