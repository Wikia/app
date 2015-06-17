<?php

class NodeFooterTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       NodeFooter::getData
	 * @covers       Node::getInnerValue
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
			[ '<footer></footer>', [ ], [ 'value' => '' ] ],
			[ '<footer>kjdflkja dafkjlsdkfj</footer>', [ ], [ 'value' => 'kjdflkja dafkjlsdkfj' ] ],
			[ '<footer>kjdflkja<ref>dafkjlsdkfj</ref></footer>', [ ], [ 'value' => 'kjdflkja<ref>dafkjlsdkfj</ref>' ] ],
		];
	}

	/**
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $string, $expectedOutput ) {
		$xml = simplexml_load_string( $string );
		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeFooter( $xml, [ ] );
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