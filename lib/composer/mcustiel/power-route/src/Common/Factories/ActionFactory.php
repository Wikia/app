<?php

namespace Mcustiel\PowerRoute\Common\Factories;

use Mcustiel\Creature\LazyCreator;
use Mcustiel\PowerRoute\Actions\GoToAction;
use Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject;
use Mcustiel\PowerRoute\PowerRoute;

class ActionFactory extends Mapping
{
    public function __construct(array $mapping)
    {
        parent::__construct(array_merge(['goto' => new LazyCreator(GoToAction::class)], $mapping));
    }

    /**
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject[]
     */
    public function createFromConfig(array $config, PowerRoute $executor)
    {
        $actions = [];

        foreach ($config as $actionData) {
            $actions[] = $this->createActionFromConfig($actionData, $executor);
        }

        return $actions;
    }

    private function createActionFromConfig($actionData, $executor)
    {
        $class = key($actionData);
        $this->checkMappingIsValid($class);

        return new ClassArgumentObject(
            $this->mapping[$class]->getInstance(),
            $this->getConstructorArgument($executor, $actionData[$class], $class)
        );
    }

    private function getConstructorArgument($executor, $argument, $id)
    {
        if ($id === 'goto') {
            $classArgument = new \stdClass();
            $classArgument->route = $argument;
            $classArgument->executor = $executor;
        } else {
            $classArgument = $argument;
        }

        return $classArgument;
    }
}
