<?php

namespace Mcustiel\Creature;

class ObjectDistributor implements CreatorInterface
{
    private $instance;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    public function getInstance()
    {
        return $this->instance;
    }
}
