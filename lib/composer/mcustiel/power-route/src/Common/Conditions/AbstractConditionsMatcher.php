<?php

namespace Mcustiel\PowerRoute\Common\Conditions;

use Mcustiel\PowerRoute\Common\ConfigOptions;
use Mcustiel\PowerRoute\Common\Factories\InputSourceFactory;
use Mcustiel\PowerRoute\Common\Factories\MatcherFactory;

abstract class AbstractConditionsMatcher
{
    /**
     * @var \Mcustiel\PowerRoute\Common\Factories\InputSourceFactory
     */
    private $inputSouceFactory;
    /**
     * @var \Mcustiel\PowerRoute\Common\Factories\MatcherFactory
     */
    private $matcherFactory;

    /**
     * @param \Mcustiel\PowerRoute\Common\Factories\InputSourceFactory $inputSouceFactory
     * @param \Mcustiel\PowerRoute\Common\Factories\MatcherFactory     $matcherFactory
     */
    public function __construct(
        InputSourceFactory $inputSouceFactory,
        MatcherFactory $matcherFactory
    ) {
        $this->inputSouceFactory = $inputSouceFactory;
        $this->matcherFactory = $matcherFactory;
    }

    /**
     * @param array $condition
     *
     * @return \Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject
     */
    protected function getInputSource(array $condition)
    {
        return $this->inputSouceFactory->createFromConfig(
            $condition[ConfigOptions::CONFIG_NODE_CONDITION_SOURCE]
        );
    }

    /**
     * @param array $condition
     *
     * @return \Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject
     */
    protected function getMatcher(array $condition)
    {
        return $this->matcherFactory->createFromConfig(
            $condition[ConfigOptions::CONFIG_NODE_CONDITION_MATCHER]
        );
    }
}
