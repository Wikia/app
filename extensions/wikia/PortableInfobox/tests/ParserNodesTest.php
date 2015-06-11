<?php

class PortableInfoboxParserNodesTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/** @dataProvider titleNodeTestProvider */
	public function testNodeTitle( $markup, $params, $expected ) {
		$data = ( new Wikia\PortableInfobox\Parser\Nodes\NodeTitle( simplexml_load_string( $markup ), $params ) )
			->getData();

		$this->assertEquals( $expected, $data );
	}

	public function titleNodeTestProvider() {
		return [
			// markup, params, expected
			[ '<title source="nombre"><default>def</default></title>',
			  [ 'nombre' => 1 ], [ 'value' => 1 ] ],
			[ '<title source="nombre"><default>def</default></title>',
			  [ ], [ 'value' => 'def' ] ],
		];
	}

	/** @dataProvider dataNodeTestProvider */
	public function testNodeData( $markup, $params, $expected ) {
		$data = ( new Wikia\PortableInfobox\Parser\Nodes\NodeData( simplexml_load_string( $markup ), $params ) )
			->getData();

		$this->assertEquals( $expected, $data );
	}

	public function dataNodeTestProvider() {
		return [
			// markup, params, expected
			[ '<data source="Season"><label>Season(s)</label><default>Lorem ipsum</default></data>',
			  [ 'Season' => 1 ], [ 'value' => 1, 'label' => 'Season(s)' ] ],
			[ '<data source="Season"><label>Season(s)</label><default>Lorem ipsum</default></data>',
			  [ ], [ 'value' => 'Lorem ipsum', 'label' => 'Season(s)' ] ],
			[ '<data source="Season"><label>Season 1</label><label>Season 2</label></data>',
			  [ 'Season' => 1 ], [ 'value' => 1, 'label' => 'Season 1' ] ],
			[ '<data source="Season"><default>Season 1</default><default>Season 2</default></data>',
			  [ ], [ 'value' => 'Season 1', 'label' => '' ] ],
		];
	}

	/** @dataProvider imageNodeTestProvider */
	public function testNodeImage( $markup, $params, $imageUrl, $expected ) {
		$node = $this->getMockBuilder( 'Wikia\PortableInfobox\Parser\Nodes\NodeImage' )
			->setConstructorArgs( [ simplexml_load_string( $markup ), $params ] )
			->setMethods( [ 'resolveImageUrl' ] )
			->getMock();
		$node->expects( $this->any() )->method( 'resolveImageUrl' )->will( $this->returnValue( $imageUrl ) );

		$this->assertEquals( $expected, $node->getData() );
	}

	public function imageNodeTestProvider() {
		return [
			// markup, params, mocked image name, expected
			[ '<image source="image2"><alt source="alt-source"><default>default-alt</default></alt>
				<caption source="caption"><default>default caption</default></caption></image>',
			  [ 'image2' => 'aaa.jpg', 'alt-source' => 'bbb', 'caption' => 'capt' ], 'aaa.jpg',
			  [ 'url' => 'aaa.jpg', 'name' => 'Aaa.jpg', 'key' => 'Aaa.jpg', 'alt' => 'bbb', 'caption' => 'capt',
				'ref' => 0 ] ],
			[ '<image source="image2"><alt source="alt-source"><default>default-alt</default></alt>
				<caption source="caption"><default>default caption</default></caption></image>',
			  [ ], 'aaa.jpg',
			  [ 'url' => 'aaa.jpg', 'name' => '', 'key' => '', 'alt' => 'default-alt', 'caption' => 'default caption',
				'ref' => null ] ],
		];
	}

	/** @dataProvider headerNodeTestProvider */
	public function testNodeHeader( $markup, $params, $expected ) {
		$data = ( new Wikia\PortableInfobox\Parser\Nodes\NodeHeader( simplexml_load_string( $markup ), $params ) )
			->getData();
		$this->assertEquals( $expected, $data );
	}

	public function headerNodeTestProvider() {
		return [
			// markup, params, expected
			[ '<header>Comandantes</header>', [ ], [ 'value' => 'Comandantes' ] ]
		];
	}

	/** @dataProvider footerNodeTestProvider */
	public function testNodeFooter( $markup, $params, $expected ) {
		$data = ( new Wikia\PortableInfobox\Parser\Nodes\NodeFooter( simplexml_load_string( $markup ), $params ) )
			->getData();
		$this->assertEquals( $expected, $data );
	}

	public function footerNodeTestProvider() {
		return [
			[ '<footer>123</footer>', [ ], [ 'value' => '123' ] ]
		];
	}

	/** @dataProvider groupNodeTestProvider */
	public function testNodeGroup( $markup, $params, $expected ) {
		$data = ( new Wikia\PortableInfobox\Parser\Nodes\NodeGroup( simplexml_load_string( $markup ), $params ) )
			->getData();

		$this->assertEquals( $expected, $data );
	}

	public function groupNodeTestProvider() {
		return [
			[ '<group><data source="elem1"><label>l1</label><default>def1</default></data><data source="elem2">
				<label>l2</label><default>def2</default></data><data source="elem3"><label>l2</label></data></group>',
			  [ 'elem1' => 1, 'elem2' => 2 ],
			  [ 'value' =>
					[
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l1', 'value' => 1 ] ],
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l2', 'value' => 2 ] ]
					]
			  ] ],
		];
	}

	/** @dataProvider comparisonNodeTestProvider */
	public function testNodeComparison( $markup, $params, $expected ) {
		$data = ( new Wikia\PortableInfobox\Parser\Nodes\NodeComparison( simplexml_load_string( $markup ), $params ) )
			->getData();

		$this->assertEquals( $expected, $data );
	}

	public function comparisonNodeTestProvider() {
		return [
			[ '<comparison><set><header>Combatientes</header><data source="lado1" /><data source="lado2" /></set>
			   <set><header>Comandantes</header><data source="comandantes1" /><data source="comandantes2" /></set>
			</comparison>', [ 'lado1' => 1, 'lado2' => 2 ],
			  [ 'value' => [
				  [
					  'type' => 'set', 'isEmpty' => false, 'data' => [
					  'value' => [
						  [ 'type' => 'header', 'isEmpty' => false, 'data' => [ 'value' => 'Combatientes' ] ],
						  [ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => '', 'value' => 1 ] ],
						  [ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => '', 'value' => 2 ] ]
					  ]
				  ]
				  ] ] ] ],
		];
	}

	/** @dataProvider labelTestProvider */
	public function testLabelTag( $markup, $params, $expected ) {
		$data = ( new \Wikia\PortableInfobox\Parser\Nodes\NodeData( simplexml_load_string( $markup ), $params ) )
			->getData();

		$this->assertEquals( $expected, $data );
	}

	public function labelTestProvider() {
		return [
			// markup, params, expected
			[ '<data source="test"><label source="test label">Test default</label></data>',
			  [ 'test' => 1, 'test label' => 2 ], [ 'label' => 2, 'value' => 1 ] ],
			[ '<data source="test"><label source="test label">default</label></data>',
			  [ 'test' => 1 ], [ 'label' => 'default', 'value' => 1 ] ],
			[ '<data source="test"><label>default</label></data>',
			  [ 'test' => 1 ], [ 'label' => 'default', 'value' => 1 ] ],
			[ '<data source="test"></data>',
			  [ 'test' => 1 ], [ 'label' => '', 'value' => 1 ] ],
		];
	}
}
