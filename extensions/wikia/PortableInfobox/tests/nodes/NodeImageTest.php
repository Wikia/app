<?php

class NodeImageTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       NodeImage::getData
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
			[ '<image source="img"></image>', [ ],
			  [ 'url' => '', 'name' => '', 'key' => '', 'alt' => null, 'caption' => null, 'ref' => null ] ],
			[ '<image source="img"></image>', [ 'img' => 'test.jpg' ],
			  [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => null, 'caption' => null, 'ref' => 0 ] ],
			[ '<image source="img"><alt><default>test alt</default></alt></image>', [ 'img' => 'test.jpg' ],
			  [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => 'test alt', 'caption' => null,
				'ref' => 1 ] ],
			[ '<image source="img"><alt source="alt source"><default>test alt</default></alt></image>',
			  [ 'img' => 'test.jpg', 'alt source' => 2 ],
			  [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => 2, 'caption' => null, 'ref' => 2 ] ],
			[ '<image source="img"><alt><default>test alt</default></alt><caption source="img"/></image>',
			  [ 'img' => 'test.jpg' ],
			  [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => 'test alt', 'caption' => 'test.jpg',
				'ref' => 3 ] ],
		];
	}

	/**
	 * @covers       NodeImage::isEmpty
	 * @dataProvider isEmptyProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testIsEmpty( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->isEmpty() );
	}

	public function isEmptyProvider() {
		return [
			[ '<image></image>', [ ], true ],
		];
	}

	/**
	 * @covers       NodeImage::getSource
	 * @dataProvider sourceProvider
	 *
	 * @param $markup
	 * @param $expected
	 */
	public function testSource( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->getSource() );
	}

	public function sourceProvider() {
		return [
			[ '<image source="img"/>', [ 'img' ] ],
			[ '<image source="img"><default>{{{img}}}</default><alt source="img" /></image>', [ 'img' ] ],
			[ '<image source="img"><alt source="alt"/><caption source="cap"/></image>', [ 'img', 'alt', 'cap' ] ],
			[ '<image source="img"><alt source="alt"><default>{{{def}}}</default></alt><caption source="cap"/></image>',
			  [ 'img', 'alt', 'def', 'cap' ] ],
			[ '<image/>', [ ] ],
		];
	}
}
