<?php

namespace Mcustiel\PowerRoute\Utils;

abstract class AbstractBuilder
{
    private $name;
    private $argument;

    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function withArgument($argument)
    {
        $this->argument = $argument;

        return $this;
    }

    public function build()
    {
        if (empty($this->name)) {
            throw new \RuntimeException('Actions, Matchers and InputSources should be identified by a name');
        }

        return [
            $this->name => $this->argument,
        ];
    }
}
