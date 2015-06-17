<?php

class NodeSetTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       NodeSet::getRenderData
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
			[ '<set><header>h</header><data source="1"/><data source="2"/></set>', [ '1' => 'one', '2' => 'two' ],
			  [ 'type' => 'set', 'data' => [ 'value' => [
				  [ 'type' => 'header', 'data' => [ 'value' => 'h' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => 'one', 'label' => '' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => 'two', 'label' => '' ] ],
			  ] ]
			  ]
			],
			[ '<set><header>h</header><data source="1"/><data source="2"/></set>', [ '1' => 'one' ],
			  [ 'type' => 'set', 'data' => [ 'value' => [
				  [ 'type' => 'header', 'data' => [ 'value' => 'h' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => 'one', 'label' => '' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => null, 'label' => '' ] ]
			  ] ]
			  ]
			],
			[ '<set><header>h</header><data source="1"/><data source="2"/></set>', [ ],
			  [ 'type' => 'set', 'data' => [ 'value' => [
				  [ 'type' => 'header', 'data' => [ 'value' => 'h' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => null, 'label' => '' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => null, 'label' => '' ] ],
			  ] ]
			  ]
			]
		];
	}

	/**
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $val1, $val2, $expectedOutput ) {
		$string = '<set>
				<header>Comparison1</header>
				<data source="val1" />
				<data source="val2" />
			</set>';

		$xml = simplexml_load_string( $string );
		$nodeSet = new Wikia\PortableInfobox\Parser\Nodes\NodeSet( $xml, [ 'val1' => $val1, 'val2' => $val2 ] );
		$data = $nodeSet->getData();
		$this->assertTrue( $nodeSet->isEmpty( $data ) == $expectedOutput );
	}

	public function testIsEmptyDataProvider() {
		return [
			[
				'val1' => 'obi-wan',
				'val2' => 'luke',
				'expectedOutput' => false
			],
			[
				'val1' => null,
				'val2' => 1,
				'expectedOutput' => false
			],
			[
				'val1' => 'yoda',
				'val2' => null,
				'expectedOutput' => false
			],
			[
				'val1' => '0',
				'val2' => '0',
				'expectedOutput' => false
			],
			[
				'val1' => null,
				'val2' => [ ],
				'expectedOutput' => true
			]
		];
	}
}