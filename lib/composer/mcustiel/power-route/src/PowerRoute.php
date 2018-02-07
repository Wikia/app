<?php

namespace Mcustiel\PowerRoute;

use Mcustiel\Creature\LazyCreator;
use Mcustiel\PowerRoute\Actions\Psr7MiddlewareAction;
use Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherFactory;
use Mcustiel\PowerRoute\Common\ConfigOptions;
use Mcustiel\PowerRoute\Common\Factories\ActionFactory;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PowerRoute
{
    const CONDITIONS_MATCHER_ALL = 'allConditionsMatcher';
    const CONDITIONS_MATCHER_ONE = 'oneConditionsMatcher';

    /**
     * @var array
     */
    private $config;
    /**
     * @var \Mcustiel\PowerRoute\Common\Factories\ActionFactory
     */
    private $actionFactory;
    /**
     * @var \Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherInterface[]
     */
    private $conditionMatchers;
    /**
     * @var \Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherFactory
     */
    private $conditionMatcherFactory;
    /**
     * @var \Mcustiel\Creature\LazyCreator
     */
    private $psr7InvokerCreator;

    public function __construct(
        array $config,
        ActionFactory $actionFactory,
        ConditionsMatcherFactory $conditionsMatcherFactory
    ) {
        $this->conditionMatchers = [];
        $this->config = $config;
        $this->conditionMatcherFactory = $conditionsMatcherFactory;
        $this->actionFactory = $actionFactory;
        $this->psr7InvokerCreator = new LazyCreator(Psr7MiddlewareAction::class);
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function start(ServerRequestInterface $request, ResponseInterface $response)
    {
        $transactionData = new TransactionData($request, $response);
        $this->execute($this->config[ConfigOptions::CONFIG_ROOT_NODE], $transactionData);

        return $transactionData->getResponse();
    }

    /**
     * @param string                             $routeName
     * @param \PowerRoute\Common\TransactionData $transactionData
     */
    public function execute($routeName, TransactionData $transactionData)
    {
        $route = $this->config[ConfigOptions::CONFIG_NODES][$routeName];

        $actions = $this->actionFactory->createFromConfig(
            $this->getActionsToRun(
                $route,
                $this->evaluateConditions($route, $transactionData->getRequest())
            ),
            $this
        );

        foreach ($actions as $action) {
            $instance = $action->getInstance();
            if (is_callable($instance)) {
                $this->psr7InvokerCreator->getInstance()->execute($transactionData, $action);
            } else {
                $instance->execute($transactionData, $action->getArgument());
            }
        }
    }

    private function evaluateConditions($route, $request)
    {
        if (!$route[ConfigOptions::CONFIG_NODE_CONDITION]) {
            return true;
        }
        if (isset($route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ALL])) {
            return $this->getConditionsMatcher(self::CONDITIONS_MATCHER_ALL)->matches(
                $route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ALL],
                $request
            );
        }
        if (isset($route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ONE])) {
            return $this->getConditionsMatcher(self::CONDITIONS_MATCHER_ONE)->matches(
                $route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ONE],
                $request
            );
        }

        throw new \RuntimeException('Invalid condition specified for route: ' . $route);
    }

    private function getConditionsMatcher($matcher)
    {
        if (!isset($this->conditionMatchers[$matcher])) {
            $this->conditionMatchers[$matcher] = $this->conditionMatcherFactory->get($matcher);
        }

        return $this->conditionMatchers[$matcher];
    }

    private function getActionsToRun($route, $matched)
    {
        if ($matched) {
            return $route[ConfigOptions::CONFIG_NODE_ACTIONS][ConfigOptions::CONFIG_NODE_ACTIONS_MATCH];
        }

        return $route[ConfigOptions::CONFIG_NODE_ACTIONS][ConfigOptions::CONFIG_NODE_ACTIONS_NOTMATCH];
    }
}
