<?php
class NodeComparisonTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
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