<?php

namespace Mcustiel\PowerRoute\Utils;

trait StaticCreation
{
    public static function create()
    {
        return new static();
    }
}
