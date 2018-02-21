<?php

namespace Mcustiel\PowerRoute\Common\Conditions;

use Mcustiel\PowerRoute\Common\Factories\InputSourceFactory;
use Mcustiel\PowerRoute\Common\Factories\MatcherFactory;

class ConditionsMatcherFactory
{
    private $conditionMatchersMap = [
        'allConditionsMatcher' => AllConditionsMatcher::class,
        'oneConditionsMatcher' => OneConditionMatcher::class,
    ];

    private $inputSouceFactory;
    private $matcherFactory;

    public function __construct(
        InputSourceFactory $inputSouceFactory,
        MatcherFactory $matcherFactory
    ) {
        $this->inputSouceFactory = $inputSouceFactory;
        $this->matcherFactory = $matcherFactory;
    }

    public function get($name)
    {
        if (isset($this->conditionMatchersMap[$name])) {
            return new $this->conditionMatchersMap[$name](
                $this->inputSouceFactory,
                $this->matcherFactory
            );
        }
        throw new \RuntimeException('Invalid condition matcher specified');
    }
}
