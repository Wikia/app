<?php

namespace Mcustiel\PowerRoute\Common\Factories;

use Mcustiel\Creature\CreatorInterface;

class Mapping
{
    protected $mapping = [];

    public function __construct(array $mapping)
    {
        $this->mapping = array_merge($this->mapping, $mapping);
    }

    public function addMapping($identifier, CreatorInterface $creator)
    {
        $this->mapping[$identifier] = $creator;
    }

    protected function checkMappingIsValid($mapping)
    {
        if (!isset($this->mapping[$mapping])) {
            throw new \Exception("Did not find a mapped class identified by $mapping");
        }
    }
}
