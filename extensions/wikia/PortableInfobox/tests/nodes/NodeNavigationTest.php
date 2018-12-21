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
			[ '<navigation></navigation>', [ ], [ 'value' => '', 'item-name' => null, 'source' => null ] ],
			[ '<navigation name="navigation"></navigation>', [ ], [ 'value' => '', 'item-name' => 'navigation', 'source' => null ] ],
			[ '<navigation>kjdflkja dafkjlsdkfj</navigation>', [ ], [ 'value' => 'kjdflkja dafkjlsdkfj', 'item-name' => null, 'source' => null ] ],
			[ '<navigation>kjdflkja<ref>dafkjlsdkfj</ref></navigation>', [ ], [ 'value' => 'kjdflkja<ref>dafkjlsdkfj</ref>', 'item-name' => null, 'source' => null ] ],
		];
	}

	/**
	 * @dataProvider isEmptyDataProvider
	 */
	public function testIsEmpty( $string, $expectedOutput ) {
		$xml = simplexml_load_string( $string );
		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeNavigation( $xml, [ ] );
		$data = $node->getData();
		$this->assertTrue( $node->isEmpty( $data ) == $expectedOutput );
	}

	public function isEmptyDataProvider() {
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
