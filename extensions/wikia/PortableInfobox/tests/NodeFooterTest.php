<?php
class NodeFooterTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}
	/**
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $string, $expectedOutput ) {
		$xml = simplexml_load_string( $string );
		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeFooter( $xml, [] );
		$data = $node->getData();
		$this->assertTrue( $node->isEmpty( $data ) == $expectedOutput );
	}
	public function testIsEmptyDataProvider() {
		return [
			[
				'string' => '<footer>goodnight</footer>',
				'expectedOutput' => false
			],
			[
				'string' => '<footer>null</footer>',
				'expectedOutput' => false
			],
			[
				'string' => '<footer>0</footer>',
				'expectedOutput' => false
			],
			[
				'string' => '<footer>\'0\'</footer>',
				'expectedOutput' => false
			],
			[
				'string' => '<footer></footer>',
				'expectedOutput' => true
			],
			[
				'string' => '<footer>    </footer>',
				'expectedOutput' => true
			]
		];
	}
}