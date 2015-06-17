<?php

class NodeComparisonTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       NodeComparison::getData
	 * @covers       Node::getDataForChildren
	 * @covers       Node::getChildNodes
	 * @dataProvider dataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testGetData( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getData() );
	}

	public function dataProvider() {
		return [
			[ '<comparison><set><data source="1"/><data source="2"/></set></comparison>',
			  [ '1' => 'one', '2' => 'two' ], [ 'value' => [
				[ 'type' => 'set', 'data' => [ 'value' => [
					[ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'one' ], 'isEmpty' => false,
					  'source' => [ '1' ] ],
					[ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'two' ], 'isEmpty' => false,
					  'source' => [ '2' ] ]
				] ], 'isEmpty' => false, 'source' => [ '1', '2' ] ] ]
			  ] ],
			[ '<comparison><set><data source="1"/><data source="2"/></set></comparison>',
			  [ ], [ 'value' => [
				[ 'type' => 'set', 'data' => [ 'value' => [
					[ 'type' => 'data', 'data' => [ 'label' => '', 'value' => null ], 'isEmpty' => true,
					  'source' => [ '1' ] ],
					[ 'type' => 'data', 'data' => [ 'label' => '', 'value' => null ], 'isEmpty' => true,
					  'source' => [ '2' ] ]
				] ], 'isEmpty' => true, 'source' => [ '1', '2' ] ] ]
			  ] ],
			[ '<comparison><set><data source="1"/><data source="2"/></set></comparison>',
			  [ '1' => 'one' ], [ 'value' => [
				[ 'type' => 'set', 'data' => [ 'value' => [
					[ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'one' ], 'isEmpty' => false,
					  'source' => [ '1' ] ],
					[ 'type' => 'data', 'data' => [ 'label' => '', 'value' => null ], 'isEmpty' => true,
					  'source' => [ '2' ] ]
				] ], 'isEmpty' => false, 'source' => [ '1', '2' ] ] ]
			  ] ],
			[ '<comparison><data source="1"><label>Test</label></data></comparison>', [ '1' => 'one' ],
			  [ 'value' => [
				  [ 'type' => 'data', 'data' => [ 'value' => 'one', 'label' => 'Test' ], 'isEmpty' => false,
					'source' => [ '1' ] ]
			  ] ] ]
		];
	}

	/**
	 * @covers       NodeComparison::getRenderData
	 * @covers       Node::getRenderDataForChildren
	 * @dataProvider renderDataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testRenderData( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getRenderData() );
	}

	public function renderDataProvider() {
		return [
			[ '<comparison><set><data source="1"/><data source="2"/></set></comparison>',
			  [ '1' => 'one', '2' => 'two' ],
			  [ 'type' => 'comparison', 'data' => [ 'value' => [
				  [ 'type' => 'set', 'data' => [ 'value' => [
					  [ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'one' ] ],
					  [ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'two' ] ]
				  ] ], ] ] ],
			  ] ],
			[ '<comparison><set><data source="1"><default>{{{1}}}</default></data><data source="2"/></set></comparison>',
			  [ '1' => 'one', '2' => 'two' ],
			  [ 'type' => 'comparison', 'data' => [ 'value' => [
				  [ 'type' => 'set', 'data' => [ 'value' => [
					  [ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'one' ] ],
					  [ 'type' => 'data', 'data' => [ 'label' => '', 'value' => 'two' ] ]
				  ] ], ] ] ],
			  ] ],
		];
	}

	/**
	 * @covers       NodeComparison::getSource
	 * @covers       Node::getSourceForChildren
	 * @dataProvider sourceDataProvider
	 *
	 * @param string $markup XML to test
	 * @param array $expected
	 */
	public function testSource( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->getSource() );
	}

	public function sourceDataProvider() {
		return [
			[ '<comparison><set><data source="1"/><data source="2"/></set></comparison>', [ '1', '2' ] ],
			[ '<comparison><set><data source="1"/><data source="1"/></set></comparison>', [ '1' ] ],
			[ '<comparison><set><data/><data source="2"><default>{{{def}}}</default></data></set></comparison>',
			  [ '2', 'def' ] ],
			[ '<comparison><set><data/><data></data></set></comparison>', [ ] ],
		];
	}

	/**
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $val1, $val2, $val3, $expectedOutput ) {
		$string = '<comparison>
			<set>
				<header>Comparison1</header>
				<data source="val1" />
				<data source="val2" />
			</set>
			<set>
				<header>Comparison2</header>
				<data source="val3" />
			</set>
			</comparison>';

		$xml = simplexml_load_string( $string );
		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeComparison( $xml, [ 'val1' => $val1, 'val2' => $val2, 'val3' => $val3 ] );
		$data = $node->getData();
		$this->assertTrue( $node->isEmpty( $data ) == $expectedOutput );
	}

	public function testIsEmptyDataProvider() {
		return [
			[
				'val1' => 'yoda',
				'val2' => 'obi-wan',
				'val3' => null,
				'expectedOutput' => false
			],
			[
				'val1' => null,
				'val2' => null,
				'val3' => '0',
				'expectedOutput' => false
			],
			[
				'val1' => 12,
				'val2' => 13,
				'val3' => 55,
				'expectedOutput' => false
			],
			[
				'val1' => '0',
				'val2' => '0',
				'val3' => '0',
				'expectedOutput' => false
			],
			[
				'val1' => null,
				'val2' => null,
				'val3' => null,
				'expectedOutput' => true
			]
		];
	}
}