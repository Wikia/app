<?php

class NodeGroupTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeGroup::getData
	 * @dataProvider groupNodeCollapseTestProvider
	 *
	 * @param $markup
	 * @param $expected
	 */
	public function testNodeGroupCollapse( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup );
		$this->assertEquals( $expected, $node->getData()[ 'collapse' ] );
	}

	public function groupNodeCollapseTestProvider() {
		return [
			[ '<group></group>', null ],
			[ '<group collapse="wrong"></group>', null ],
			[ '<group collapse="open"></group>', 'open' ],
			[ '<group collapse="closed"></group>', 'closed' ]
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeGroup::getData
	 * @dataProvider groupNodeTestProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testNodeGroup( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getData() );
	}

	public function groupNodeTestProvider() {
		return [
			[ '<group><data source="elem1"><label>l1</label><default>def1</default></data><data source="elem2">
				<label>l2</label><default>def2</default></data><data source="elem3"><label>l2</label></data></group>',
			  [ 'elem1' => 1, 'elem2' => 2 ],
			  [ 'value' =>
					[
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l1', 'value' => 1 ],
						  'source' => [ 'elem1' ] ],
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l2', 'value' => 2 ],
						  'source' => [ 'elem2' ] ],
						[ 'type' => 'data', 'isEmpty' => true, 'data' => [ 'label' => 'l2', 'value' => null ],
						  'source' => [ 'elem3' ] ]
					],
				'layout' => 'default',
				'collapse' => null
			  ] ],
			[ '<group layout="horizontal"><data source="elem1"><label>l1</label><default>def1</default></data><data source="elem2">
				<label>l2</label><default>def2</default></data><data source="elem3"><label>l2</label></data></group>',
			  [ 'elem1' => 1, 'elem2' => 2 ],
			  [ 'value' =>
					[
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l1', 'value' => 1 ],
						  'source' => [ 'elem1' ] ],
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l2', 'value' => 2 ],
						  'source' => [ 'elem2' ] ],
						[ 'type' => 'data', 'isEmpty' => true, 'data' => [ 'label' => 'l2', 'value' => null ],
						  'source' => [ 'elem3' ] ],
					],
				'layout' => 'horizontal',
				'collapse' => null
			  ] ],
			[ '<group  layout="loool"><data source="elem1"><label>l1</label><default>def1</default></data><data source="elem2">
				<label>l2</label><default>def2</default></data><data source="elem3"><label>l2</label></data></group>',
			  [ 'elem1' => 1, 'elem2' => 2 ],
			  [ 'value' =>
					[
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l1', 'value' => 1 ],
						  'source' => [ 'elem1' ] ],
						[ 'type' => 'data', 'isEmpty' => false, 'data' => [ 'label' => 'l2', 'value' => 2 ],
						  'source' => [ 'elem2' ] ],
						[ 'type' => 'data', 'isEmpty' => true, 'data' => [ 'label' => 'l2', 'value' => null ],
						  'source' => [ 'elem3' ] ],
					],
				'layout' => 'default',
				'collapse' => null
			  ] ],
			[ '<group show="incomplete"><header>h</header><data source="1"/><data source="2"/></group>',
			  [ '1' => 'one', '2' => 'two' ],
			  [ 'value' => [
				  [ 'type' => 'header', 'data' => [ 'value' => 'h' ], 'isEmpty' => false, 'source' => [ ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => 'one', 'label' => '' ], 'isEmpty' => false,
					'source' => [ '1' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => 'two', 'label' => '' ], 'isEmpty' => false,
					'source' => [ '2' ] ],
			  ],
				'layout' => 'default',
				'collapse' => null
			  ] ],
			[ '<group show="incomplete"><header>h</header><data source="1"/><data source="2"/></group>',
			  [ '1' => 'one' ],
			  [ 'value' => [
				  [ 'type' => 'header', 'data' => [ 'value' => 'h' ], 'isEmpty' => false, 'source' => [ ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => 'one', 'label' => '' ], 'isEmpty' => false,
					'source' => [ '1' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => null, 'label' => '' ], 'isEmpty' => true,
					'source' => [ '2' ] ]
			  ],
				'layout' => 'default',
				'collapse' => null
			  ] ],
			[ '<group show="incomplete"><header>h</header><data source="1"/><data source="2"/></group>', [ ],
			  [ 'value' => [
				  [ 'type' => 'header', 'data' => [ 'value' => 'h' ], 'isEmpty' => false, 'source' => [ ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => null, 'label' => '' ], 'isEmpty' => true,
					'source' => [ '1' ] ],
				  [ 'type' => 'data', 'data' => [ 'value' => null, 'label' => '' ], 'isEmpty' => true,
					'source' => [ '2' ] ],
			  ],
				'layout' => 'default',
				'collapse' => null
			  ] ]
		];
	}
}