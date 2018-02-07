<?php

namespace Mcustiel\PowerRoute\Common;

use Psr\Http\Message\UriInterface;

trait RequestUrlAccess
{
    private function getValueFromUrlPlaceholder($name, UriInterface $uri)
    {
        switch ($name) {
            case 'full':
            case null:
                return $uri->__toString();
            case 'host':
                return $uri->getHost();
            case 'scheme':
                return $uri->getScheme();
            case 'authority':
                return $uri->getAuthority();
            case 'fragment':
                return $uri->getFragment();
            case 'path':
                return $uri->getPath();
            case 'port':
                return $uri->getPort();
            case 'query':
                return $uri->getQuery();
            case 'user-info':
                return $uri->getUserInfo();
            default:
                throw new \Exception('Invalid config');
        }
    }
}
