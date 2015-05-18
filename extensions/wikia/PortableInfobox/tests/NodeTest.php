<?php

class NodeTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $season, $expectedOutput ) {
		$string = '<data source="season"><label>Season</label></data>';
		$xml = simplexml_load_string( $string );

		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeData( $xml, [ 'season' => $season ] );
		$nodeData = $node->getData();
		$this->assertTrue( $node->isEmpty($nodeData['value']) == $expectedOutput );
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
				'season' => null,
				'expectedOutput' => true
			],
			[
				'season' => [],
				'expectedOutput' => true
			],
			[
				'season' => '',
				'expectedOutput' => true
			]
		];
	}
}
