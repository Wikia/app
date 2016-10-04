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

		$this->assertEquals( $expected, $node->getSource() );
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
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getSourceLabel
	 * @dataProvider sourceLabelDataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testSourceLabel( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getSourceLabel() );
	}

	public function sourceLabelDataProvider() {
		return [
			[ '<data source="test"></data>', [ ], ['test' => ''] ],
			[ '<image source="test"/>', [ ], ['test' => ''] ],
			[ '<title source="test"/>', [ ], ['test' => ''] ],
			[ '<data source="test"><default>{{{test}}}</default></data>',
				[ ], ['test' => ''] ],
			[ '<data source="test"><label source="test">{{{test}}}</label><default>{{{test}}}</default></data>',
				[ ], ['test' => '{{{test}}}'] ],
			[ '<data source="test"><label>testLabel</label></data>', [ ], ['test' => 'testLabel'] ],
			[ '<data></data>', [ ], [ ] ],
			[ '<group><data source="test"><label>labelInsideGroup</label></data></group>', [], ['test' =>'labelInsideGroup'] ],
			[ '<group>' .
				'<data source="test"><label>labelInsideGroup</label></data>' .
				'<data source="test2"><label>labelInsideGroup2</label></data>' .
				'</group>',
				[], ['test' =>'labelInsideGroup', 'test2' =>'labelInsideGroup2'] ],
			[ '<group>' .
				'<title source="title"/>' .
				'<image source="image"/>' .
				'<data source="test"><label>labelInsideGroup</label></data>' .
				'<data source="test2"><label>labelInsideGroup2</label></data>' .
				'</group>',
				[], ['test' =>'labelInsideGroup', 'test2' =>'labelInsideGroup2', 'title' => '', 'image' => ''] ],
			[ '<data source="test"><default>{{{test 2}}}</default></data>', [ ], [ 'test' => '', 'test 2' => '' ] ],
			[ '<data source="test1"><default>{{#if: {{{test2|}}}| [[{{{test2}}} with some text]] }}</default></data>',
				[ ], [ 'test1' => '', 'test2' => '' ] ],
			[ '<data><default>{{#switch: {{{test2|}}}|{{{test3}}}|{{{test4|kdjk|sajdkfj|}}}]] }}</default></data>',
				[ ], [ 'test2' => '', 'test3' => '', 'test4' => '' ] ],
			[ '<data source="test1">' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ 'test1' => 'blabla' ], [ 'test1' => '', 'test2' => '', 'test3' => '', 'test4' => '', 'test5' => '' ] ],
			[ '<data>' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ ], [ 'test2' => '', 'test3' => '', 'test4' => '', 'test5' => '' ] ],
			[ '<data source="test1">' .
				'<label>label</label>' .
				'<default>{{#if: {{{test2|}}}| [[{{{test2}}} with some text]] }}</default>' .
				'</data>',
				[ ], [ 'test1' => 'label (test1)', 'test2' => 'label (test2)' ] ],
			[ '<data>' .
				'<label>other label</label>' .
				'<default>{{#switch: {{{test2|}}}|{{{test3}}}|{{{test4|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ ], [ 'test2' => 'other label (test2)', 'test3' => 'other label (test3)', 'test4' => 'other label (test4)' ] ],
			[ '<data source="test1">' .
				'<label>next label</label>' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ 'test1' => 'blabla' ],
				[
					'test1' => 'next label (test1)',
					'test2' => 'next label (test2)',
					'test3' => 'next label (test3)',
					'test4' => 'next label (test4)',
					'test5' => 'next label (test5)'
				]
			],
			[ '<data>' .
				'<label>last label</label>' .
				'<format>my {{{test2}}}$$$</format>' .
				'<default>{{#switch: {{{test3|}}}|{{{test4}}}|{{{test5|kdjk|sajdkfj|}}}]] }}</default>' .
				'</data>',
				[ ],
				[
					'test2' => 'last label (test2)',
					'test3' => 'last label (test3)',
					'test4' => 'last label (test4)',
					'test5' => 'last label (test5)'
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
			[ '<data source="test"></data>', [ 'test' => 'test' ], [ 'value' => 'test', 'label' => '' ] ],
			[ '<data source="test"><default>def</default></data>', [ ], [ 'value' => 'def', 'label' => '' ] ],
			[ '<data source="test"><label>l</label><default>def</default></data>', [ ],
			  [ 'value' => 'def', 'label' => 'l' ] ],
			[ '<data source="test"><label source="l">jjj</label><default>def</default></data>', [ 'l' => 1 ],
			  [ 'value' => 'def', 'label' => 'jjj' ] ],
			[ '<data source="test"><label source="l" /><default>def</default></data>', [ 'l' => 1 ],
			  [ 'value' => 'def', 'label' => '' ] ],
			[ '<data source="test"><label>l</label><default>def</default></data>', [ 'test' => 1 ],
			  [ 'value' => 1, 'label' => 'l' ] ],
			[ '<data></data>', [ ], [ 'label' => '', 'value' => null ] ],
			[ '<data source="test"><label>l</label><format>{{{test}}}%</format><default>def</default></data>', [ 'test' => 1 ],
			  [ 'value' => '{{{test}}}%', 'label' => 'l' ] ],
			[ '<data source="test"><label>l</label><format>{{{not_defined_var}}}%</format><default>def</default></data>', [ 'test' => 1 ],
				[ 'value' => '{{{not_defined_var}}}%', 'label' => 'l' ] ],
			[ '<data source="test"><label>l</label><format>{{{test}}}%</format><default>def</default></data>', [ ],
				[ 'value' => 'def', 'label' => 'l' ] ],
			[ '<data source="test"><format>{{{test}}}%</format></data>', [ 'test' => 0 ],
				[ 'value' => '{{{test}}}%', 'label' => '' ] ],
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
				[ 'type' => 'data', 'data' => [ 'value' => 'test', 'label' => '' ] ]
			]
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
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $season, $expectedOutput ) {
		$string = '<data source="season"><label>Season</label></data>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeData( $xml, [ 'season' => $season ] );
		$nodeData = $node->getData();
		$this->assertTrue( $node->isEmpty( $nodeData ) == $expectedOutput );
	}

	public function testIsEmptyDataProvider() {
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
