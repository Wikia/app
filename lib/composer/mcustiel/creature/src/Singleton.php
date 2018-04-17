<?php

namespace Mcustiel\Creature;

trait Singleton
{
    private $instance;

    public function getInstance()
    {
        if ($this->instance === null) {
            $this->instance = parent::getInstance();
        }

        return $this->instance;
    }
}
