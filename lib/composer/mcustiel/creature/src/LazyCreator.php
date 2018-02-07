<?php

namespace Mcustiel\Creature;

class LazyCreator implements CreatorInterface
{
    private $className;
    private $arguments = [];

    public function __construct($className, array $arguments = [])
    {
        $this->className = $className;
        $this->arguments = $arguments;
    }

    public function getInstance()
    {
        if (!class_exists($this->className)) {
            throw new \RuntimeException(
                'Error creating instance. Class does not exists: ' . $this->className
            );
        }

        return new $this->className(...$this->arguments);
    }
}
