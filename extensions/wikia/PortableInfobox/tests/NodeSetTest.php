<?php
class NodeSetTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
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
				'val2' => [],
				'expectedOutput' => true
			]
		];
	}
}