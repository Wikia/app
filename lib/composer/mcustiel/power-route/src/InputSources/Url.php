<?php

namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Common\RequestUrlAccess;
use Psr\Http\Message\ServerRequestInterface;

class Url implements InputSourceInterface
{
    use RequestUrlAccess;

    public function getValue(ServerRequestInterface $request, $argument = null)
    {
        return $this->getValueFromUrlPlaceholder($argument, $request->getUri());
    }
}
