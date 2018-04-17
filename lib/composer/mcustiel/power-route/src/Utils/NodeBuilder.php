<?php

namespace Mcustiel\PowerRoute\Utils;

use Mcustiel\PowerRoute\Common\ConfigOptions;

class NodeBuilder
{
    use StaticCreation;

    const CONDITION_OPERATOR_ONE = ConfigOptions::CONFIG_NODE_CONDITION_ONE;
    const CONDITION_OPERATOR_ALL = ConfigOptions::CONFIG_NODE_CONDITION_ALL;

    private $conditions;
    private $operator;
    private $actions;

    public function __construct()
    {
        $this->conditions = [];
        $this->actions = [
            ConfigOptions::CONFIG_NODE_ACTIONS_MATCH => [],
            ConfigOptions::CONFIG_NODE_ACTIONS_NOTMATCH => [],
        ];
        $this->operator = self::CONDITION_OPERATOR_ONE;
    }

    public function addCondition(InputSourceBuilder $inputSourceBuilder, MatcherBuilder $matcherBuilder)
    {
        $this->conditions[] = [
            ConfigOptions::CONFIG_NODE_CONDITION_MATCHER => $matcherBuilder->build(),
            ConfigOptions::CONFIG_NODE_CONDITION_SOURCE => $inputSourceBuilder->build(),
        ];

        return $this;
    }

    public function addActionIfConditionMatches($name, $argument)
    {
        $this->actions[ConfigOptions::CONFIG_NODE_ACTIONS_MATCH][] = [$name => $argument];

        return $this;
    }

    public function addActionIfConditionDoesNotMatch($name, $argument)
    {
        $this->actions[ConfigOptions::CONFIG_NODE_ACTIONS_NOTMATCH][] = [$name => $argument];

        return $this;
    }

    public function withConditionOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    public function build()
    {
        return [
            ConfigOptions::CONFIG_NODE_CONDITION => [
                $this->operator => $this->conditions,
            ],
            ConfigOptions::CONFIG_NODE_ACTIONS => $this->actions,
        ];
    }
}
