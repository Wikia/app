<?php

namespace Mcustiel\PowerRoute\Common\Conditions;

class ClassArgumentObject
{
    private $instance;
    private $argument;

    public function __construct($instance, $argument)
    {
        $this->instance = $instance;
        $this->argument = $argument;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function getArgument()
    {
        return $this->argument;
    }
}
