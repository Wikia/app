<?php

class NodeNavigationTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeNavigation::getData
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\Node::getInnerValue
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
			[ '<navigation></navigation>', [ ], [ 'value' => '' ] ],
			[ '<navigation>kjdflkja dafkjlsdkfj</navigation>', [ ], [ 'value' => 'kjdflkja dafkjlsdkfj' ] ],
			[ '<navigation>kjdflkja<ref>dafkjlsdkfj</ref></navigation>', [ ], [ 'value' => 'kjdflkja<ref>dafkjlsdkfj</ref>' ] ],
		];
	}

	/**
	 * @dataProvider testIsEmptyDataProvider
	 */
	public function testIsEmpty( $string, $expectedOutput ) {
		$xml = simplexml_load_string( $string );
		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeNavigation( $xml, [ ] );
		$data = $node->getData();
		$this->assertTrue( $node->isEmpty( $data ) == $expectedOutput );
	}

	public function testIsEmptyDataProvider() {
		return [
			[
				'string' => '<navigation>goodnight</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation>null</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation>0</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation>\'0\'</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation></navigation>',
				'expectedOutput' => true
			],
			[
				'string' => '<navigation>    </navigation>',
				'expectedOutput' => true
			]
		];
	}
}