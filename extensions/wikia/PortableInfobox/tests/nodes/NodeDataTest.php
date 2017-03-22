<?php

class NodeDataTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getSource
	 * @dataProvider sourceDataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testSource( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getSources() );
	}

	public function sourceDataProvider() {
		return [
			[ '<data source="test"></data>', [ ], [ 'test' ] ],
			[ '<data source="test"><label source="test">{{{test}}}</label><default>{{{test}}}</default></data>',
			  [ ], [ 'test' ] ],
			[ '<data source="test"><default>{{{test 2}}}</default></data>', [ ], [ 'test', 'test 2' ] ],
			[ '<data></data>', [ ], [ ] ],
			[ '<data source="test1"><default>{{#if: {{{test2|}}}| [[{{{test2}}} with some text]] }}</default></data>',
			  [ ], [ 'test1', 'test2' ] ],
			[ '<data><default>{{#switch: {{{test2|}}}|{{{test3}}}|{{{test4|kdjk|sajdkfj|}}}]] }}</default></data>',
			  [ ], [ 'test2', 'test3', 'test4' ] ],
			[ '<data source="test1"><format>my {{{test2}}}$$$</format><default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default></data>',
				[ 'test1' => 'blabla' ], [ 'test1', 'test2', 'test3', 'test4', 'test5' ] ],
			[ '<data><format>my {{{test2}}}$$$</format><default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default></data>',
				[ ], [ 'test2', 'test3', 'test4', 'test5' ] ]
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getSourcesMetadata
	 * @dataProvider sourcesMetadataDataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testSourcesMetadata( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getSourcesMetadata() );
	}

	public function sourcesMetadataDataProvider() {
		return [
			[
				'<data source="test"></data>',
				[],
				[
					'test' => [
						'label' => '',
						'primary' => true
					]
				]
			],
			[
				'<image source="test"/>',
				[],
				[
					'test' => [
						'label' => '',
						'primary' => true
					]
				]
			],
			[
				'<title source="test"/>',
				[],
				[
					'test' => [
						'label' => '',
						'primary' => true
					]
				]
			],
			[
				'<data source="test"><default>{{{test}}}</default></data>',
				[],
				[
					'test' => [
						'label' => '',
						'primary' => true
					]
				]
			],
			[
				'<data source="test"><label source="test">{{{test}}}</label><default>{{{test}}}</default></data>',
				[],
				[
					'test' => [
						'label' => '{{{test}}}',
						'primary' => true
					]
				]
			],
			[
				'<data source="test"><label>testLabel</label></data>',
				[],
				[
					'test' => [
						'label' => 'testLabel',
						'primary' => true
					]
				]
			],
			[ '<data></data>', [], [] ],
			[
				'<data source="test"><default>{{{test 2}}}</default></data>',
				[],
				[
					'test' => [
						'label' => '',
						'primary' => true
					],
					'test 2' => [
						'label' => ''
					]
				]
			],
			[
				'<data source="test1"><default>{{#if: {{{test2|}}}| [[{{{test2}}} with some text]] }}</default></data>',
				[],
				[
					'test1' => [
						'label' => '',
						'primary' => true
					],
					'test2' => [
						'label' => ''
					]
				]
			],
			[
				'<data><default>{{#switch: {{{test2|}}}|{{{test3}}}|{{{test4|kdjk|sajdkfj|}}}]] }}</default></data>',
				[],
				[
					'test2' => [
						'label' => ''
					],
					'test3' => [
						'label' => ''
					],
					'test4' => [
						'label' => ''
					]
				]
			],
			[
				'<data source="test1">' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ 'test1' => 'blabla' ],
				[
					'test1' => [
						'label' => '',
						'primary' => true
					],
					'test2' => [
						'label' => ''
					],
					'test3' => [
						'label' => ''
					],
					'test4' => [
						'label' => ''
					],
					'test5' => [
						'label' => ''
					]
				]
			],
			[
				'<data>' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[],
				[
					'test2' => [
						'label' => ''
					],
					'test3' => [
						'label' => ''
					],
					'test4' => [
						'label' => ''
					],
					'test5' => [
						'label' => ''
					]
				]
			],
			[
				'<data source="test1">' .
				'<label>label</label>' .
				'<default>{{#if: {{{test2|}}}| [[{{{test2}}} with some text]] }}</default>' .
				'</data>',
				[],
				[
					'test1' => [
						'label' => 'label (test1)',
						'primary' => true
					],
					'test2' => [
						'label' => 'label (test2)'
					],
				]
			],
			[
				'<data>' .
				'<label>other label</label>' .
				'<default>{{#switch: {{{test2|}}}|{{{test3}}}|{{{test4|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[],
				[
					'test2' => [
						'label' => 'other label (test2)'
					],
					'test3' => [
						'label' => 'other label (test3)'
					],
					'test4' => [
						'label' => 'other label (test4)'
					],
				]
			],
			[
				'<data source="test1">' .
				'<label>next label</label>' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ 'test1' => 'blabla' ],
				[
					'test1' => [
						'label' => 'next label (test1)',
						'primary' => true
					],
					'test2' => [
						'label' => 'next label (test2)'
					],
					'test3' => [
						'label' => 'next label (test3)'
					],
					'test4' => [
						'label' => 'next label (test4)'
					],
					'test5' => [
						'label' => 'next label (test5)'
					]
				]
			],
			[
				'<data>' .
				'<label>last label</label>' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[],
				[
					'test2' => [
						'label' => 'last label (test2)'
					],
					'test3' => [
						'label' => 'last label (test3)'
					],
					'test4' => [
						'label' => 'last label (test4)'
					],
					'test5' => [
						'label' => 'last label (test5)'
					]
				]
			]
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getMetadata
	 * @dataProvider metadataDataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testMetadata( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getMetadata() );
	}

	public function metadataDataProvider() {
		return [
			[
				'<infobox><data source="test"></data></infobox>',
				[],
				[
					[
						'type' => 'data',
						'sources' => [
							'test' => [
								'label' => '',
								'primary' => true
							]
						]
					]
				]
			],
			[
				'<infobox><image source="test"/></infobox>',
				[],
				[
					[
						'type' => 'image',
						'sources' => [
							'test' => [
								'label' => '',
								'primary' => true
							]
						]
					]
				]
			],
			[
				'<infobox><title source="test"/></infobox>',
				[],
				[
					[
						'type' => 'title',
						'sources' => [
							'test' => [
								'label' => '',
								'primary' => true
							]
						]
					]
				]
			],
			[
				'<infobox><data source="test"><default>{{{test}}}</default></data></infobox>',
				[],
				[
					[
						'type' => 'data',
						'sources' => [
							'test' => [
								'label' => '',
								'primary' => true
							]
						]
					]
				]
			],
			[
				'<infobox><group>' .
				'<image source="test1" />' .
				'<title source="test2" />' .
				'</group></infobox>',
				[],
				[
					[
						'type' => 'group',
						'metadata' => [
							[
								'type' => 'image',
								'sources' => [
									'test1' => [
										'label' => '',
										'primary' => true
									]
								]
							],
							[
								'type' => 'title',
								'sources' => [
									'test2' => [
										'label' => '',
										'primary' => true
									]
								]
							]
						]
					]
				]
			],
			[
				'<infobox><group>' .
				'<data source="test1"><label>Label</label></data>' .
				'<group>' .
				'<image source="test2" />' .
				'<title source="test3" />' .
				'</group>' .
				'</group></infobox>',
				[],
				[
					[
						'type' => 'group',
						'metadata' => [
							[
								'type' => 'data',
								'sources' => [
									'test1' => [
										'label' => 'Label',
										'primary' => true
									]
								]
							],
							[
								'type' => 'group',
								'metadata' => [
									[
										'type' => 'image',
										'sources' => [
											'test2' => [
												'label' => '',
												'primary' => true
											]
										]
									],
									[
										'type' => 'title',
										'sources' => [
											'test3' => [
												'label' => '',
												'primary' => true
											]
										]
									]
								]
							]
						]
					]
				]
			]
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getExternalParser
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::setExternalParser
	 * @dataProvider parserTestDataProvider
	 *
	 * @param $parser
	 * @param $expected
	 */
	public function testExternalParserSetUp( $parser, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( '<data></data>', [ ] );

		$this->assertEquals( $expected, $node->setExternalParser( $parser )->getExternalParser() );
	}

	public function parserTestDataProvider() {
		return [
			[ null, new \Wikia\PortableInfobox\Parser\SimpleParser() ],
			[ new \Wikia\PortableInfobox\Parser\SimpleParser(), new \Wikia\PortableInfobox\Parser\SimpleParser() ]
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeData::getData
	 * @dataProvider dataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testData( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getData() );
	}

	public function dataProvider() {
		return [
			[ '<data source="test"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test" span="2"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '', 'span' => '2', 'layout' => null ] ],
			[ '<data source="test" span="2.2"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test" span="non_numeric_span"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test" layout="wrong layout"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test" layout="default"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => 'default' ] ],
			[ '<data source="test"><default>def</default></data>', [ ], [ 'value' => 'def', 'label' => '', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label>l</label><default>def</default></data>', [ ],
			  [ 'value' => 'def', 'label' => 'l', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label source="l">jjj</label><default>def</default></data>', [ 'l' => 1 ],
			  [ 'value' => 'def', 'label' => 'jjj', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label source="l" /><default>def</default></data>', [ 'l' => 1 ],
			  [ 'value' => 'def', 'label' => '', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label>l</label><default>def</default></data>', [ 'test' => 1 ],
			  [ 'value' => 1, 'label' => 'l', 'span' => 1, 'layout' => null ] ],
			[ '<data></data>', [ ], [ 'label' => '', 'value' => null, 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label>l</label><format>{{{test}}}%</format><default>def</default></data>', [ 'test' => 1 ],
			  [ 'value' => '{{{test}}}%', 'label' => 'l', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label>l</label><format>{{{not_defined_var}}}%</format><default>def</default></data>', [ 'test' => 1 ],
				[ 'value' => '{{{not_defined_var}}}%', 'label' => 'l', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><label>l</label><format>{{{test}}}%</format><default>def</default></data>', [ ],
				[ 'value' => 'def', 'label' => 'l', 'span' => 1, 'layout' => null ] ],
			[ '<data source="test"><format>{{{test}}}%</format></data>', [ 'test' => 0 ],
				[ 'value' => '{{{test}}}%', 'label' => '', 'span' => 1, 'layout' => null ] ],
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getRenderData
	 * @dataProvider dataRenderProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testRenderData( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getRenderData() );
	}

	public function dataRenderProvider() {
		return [
			[ '<data source="test"></data>',
				[ 'test' => 'test' ],
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ]
			],
			[ '<data source="test" layout="default"></data>',
				[ 'test' => 'test' ],
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => 'default' ] ]
			],
			[ '<data source="test" layout="wrong_layout"></data>',
				[ 'test' => 'test' ],
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ]
			],
			[ '<data source="test" span="2"></data>',
				[ 'test' => 'test' ],
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '', 'span' => '2', 'layout' => null ] ]
			],
			[ '<data source="test" span="2.2"></data>',
				[ 'test' => 'test' ],
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ]
			],
			[ '<data source="test" span="non numeric span"></data>',
				[ 'test' => 'test' ],
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '', 'span' => 1, 'layout' => null ] ]
			],
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::isType
	 * @dataProvider isTypeDataProvider
	 *
	 * @param $markup
	 * @param $typeToCheck
	 * @param $expected
	 */
	public function testIsType( $markup, $typeToCheck, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->isType( $typeToCheck ) );
	}

	public function isTypeDataProvider() {
		return [
			[ '<data source="test"></data>', 'data', true ],
			[ '<data source="test"></data>', 'DaTa', true ],
			[ '<data source="test"></data>', 'aksdjflkj', false ],
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getType
	 * @dataProvider typeDataProvider
	 *
	 * @param $markup
	 * @param $expected
	 */
	public function testType( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->getType() );
	}

	public function typeDataProvider() {
		return [
			[ '<data source="test"></data>', 'data' ],
			[ '<infobox></infobox>', 'infobox' ],
		];
	}

	/**
	 * @dataProvider isEmptyDataProvider
	 */
	public function testIsEmpty( $season, $expectedOutput ) {
		$string = '<data source="season"><label>Season</label></data>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeData( $xml, [ 'season' => $season ] );
		$nodeData = $node->getData();
		$this->assertTrue( $node->isEmpty( $nodeData ) == $expectedOutput );
	}

	public function isEmptyDataProvider() {
		return [
			[
				'season' => '0',
				'expectedOutput' => false
			],
			[
				'season' => '1',
				'expectedOutput' => false
			],
			[
				'season' => 'one',
				'expectedOutput' => false
			],
			[
				'season' => 'null',
				'expectedOutput' => false
			],
			[
				'season' => 'false',
				'expectedOutput' => false
			],
			[
				'season' => '  ',
				'expectedOutput' => false
			],
			[
				'season' => null,
				'expectedOutput' => true
			],
			[
				'season' => [ ],
				'expectedOutput' => true
			],
			[
				'season' => '',
				'expectedOutput' => true
			],
			[
				'season' => 5,
				'expectedOutput' => false
			],
			[
				'season' => 0,
				'expectedOutput' => false
			]
		];
	}
}
