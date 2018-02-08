<?php

namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;

class Header implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request, $argument = null)
    {
        $header = $request->getHeaderLine($argument);

        return $header ?: null;
    }
}
