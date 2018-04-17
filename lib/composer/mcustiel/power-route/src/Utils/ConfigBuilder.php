<?php

namespace Mcustiel\PowerRoute\Utils;

use Mcustiel\PowerRoute\Common\ConfigOptions;

class ConfigBuilder
{
    use StaticCreation;

    private $start;
    private $nodes;

    public function __construct()
    {
        $this->nodes = [];
    }

    public function addNode($name, NodeBuilder $builder)
    {
        $this->nodes[$name] = $builder->build();
    }

    public function withStartNode($name)
    {
        $this->start = $name;
    }

    public function build()
    {
        return [
            ConfigOptions::CONFIG_ROOT_NODE => $this->start,
            ConfigOptions::CONFIG_NODES => $this->nodes,
        ];
    }
}
