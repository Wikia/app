<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Utils;

use Mcustiel\PowerRoute\Utils\ConfigBuilder;
use Mcustiel\PowerRoute\Utils\InputSourceBuilder;
use Mcustiel\PowerRoute\Utils\MatcherBuilder;
use Mcustiel\PowerRoute\Utils\NodeBuilder;

class ConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Utils\ConfigBuilder
     */
    private $configBuilder;

    /**
     * @before
     */
    public function prepare()
    {
        $this->configBuilder = ConfigBuilder::create();
    }

    /**
     * @test
     */
    public function shouldBuildACorrectArray()
    {
        $expectedNode = [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['coconut' => 'banana'],
                        'matcher' => ['potato' => 'tomato'],
                    ],
                    [
                        'input-source' => ['strawberry' => 'pear'],
                        'matcher' => ['paprika' => 'onion'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['potatoAction' => 'tomatoAction'],
                    ['coconutAction' => 'bananaAction'],
                ],
                'else' => [
                    ['onionAction' => 'paprikaAction'],
                    ['pearAction' => 'strawberryAction'],
                ],
            ],
        ];
        $expected = [
            'start' => 'theNode',
            'nodes' => [
                'theNode' => $expectedNode,
            ],
        ];

        $nodeBuilder = NodeBuilder::create();

        $matcher = MatcherBuilder::create()->withArgument('tomato')->withName('potato');
        $inputSource = InputSourceBuilder::create()->withArgument('banana')->withName('coconut');
        $nodeBuilder->addCondition($inputSource, $matcher);
        $matcher = MatcherBuilder::create()->withArgument('onion')->withName('paprika');
        $inputSource = InputSourceBuilder::create()->withArgument('pear')->withName('strawberry');
        $nodeBuilder->addCondition($inputSource, $matcher)
            ->withConditionOperator(NodeBuilder::CONDITION_OPERATOR_ONE)
            ->addActionIfConditionMatches('potatoAction', 'tomatoAction')
            ->addActionIfconditionmatches('coconutAction', 'bananaAction')
            ->addActionIfConditionDoesNotMatch('onionAction', 'paprikaAction')
            ->addActionIfConditionDoesNotMatch('pearAction', 'strawberryAction');
        $this->configBuilder->addNode('theNode', $nodeBuilder);
        $this->configBuilder->withStartNode('theNode');
        $this->assertEquals($expected, $this->configBuilder->build());
    }
}
