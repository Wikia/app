<?php


class NodePanelTest extends WikiaBaseTest {
	/**
	 * @dataProvider groupPanelCollapseTestProvider
	 * @param $markup
	 * @param $expected
	 */
	public function testPanelGroupCollapse( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup );
		$this->assertEquals( $expected, $node->getData()[ 'collapse' ] );
	}

	public function groupPanelCollapseTestProvider() {
		return [
			[ '<panel></panel>', null ],
			[ '<panel collapse="wrong"></panel>', null ],
			[ '<panel collapse="open"></panel>', 'open' ],
			[ '<panel collapse="closed"></panel>', 'closed' ]
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
			[ '<panel name="asdf"><header>h</header></panel>',
				[],
				[
					'value' => [
						[ 'type' => 'header', 'data' => [ 'value' => 'h', 'item-name' => null, 'source' => null ] ],
					],
					'collapse' => null,
					'item-name' => 'asdf',
				]
			],
			[ '<panel name="asdf"><section><data source="elem1"><label>l1</label></data></section></panel>',
				['elem1' => 1],
				[
					'value' => [
						['type' => 'section', 'data' => [ 'item-name' => null, 'label' => '', 'value' => [ [ 'type' => 'data', 'data' => [ 'label' => 'l1', 'value' => 1, 'span' => 1, 'layout' => null, 'item-name' => null, 'source' => 'elem1' ] ] ] ] ],
					],
					'collapse' => null,
					'item-name' => 'asdf',
				]
			],
			[ '<panel name="asdf"><header>h</header><section><data source="elem1"><label>l1</label></data></section></panel>',
				['elem1' => 1],
				[
					'value' => [
						[ 'type' => 'header', 'data' => [ 'value' => 'h', 'item-name' => null, 'source' => null ] ],
						['type' => 'section', 'data' => [ 'item-name' => null, 'label' => '', 'value' => [ [ 'type' => 'data', 'data' => [ 'label' => 'l1', 'value' => 1, 'span' => 1, 'layout' => null, 'item-name' => null, 'source' => 'elem1' ] ] ] ] ],
					],
					'collapse' => null,
					'item-name' => 'asdf',
				]
			],
			[ '<panel name="asdf"><header>h</header><section><label>sl</label><data source="elem1"><label>l1</label></data></section></panel>',
				['elem1' => 1],
				[
					'value' => [
						[ 'type' => 'header', 'data' => [ 'value' => 'h', 'item-name' => null, 'source' => null ] ],
						['type' => 'section', 'data' => [ 'item-name' => null, 'label' => 'sl', 'value' => [ [ 'type' => 'data', 'data' => [ 'label' => 'l1', 'value' => 1, 'span' => 1, 'layout' => null, 'item-name' => null, 'source' => 'elem1' ] ] ] ] ],
					],
					'collapse' => null,
					'item-name' => 'asdf',
				]
			],
			// other elements than section and header can not be direct child of panel and are omitted
			[ '<panel name="asdf"><group><header>asdf</header><data source="elem1"><label>l1</label></data></group></panel>',
				['elem1' => 1],
				[
					'value' => [],
					'collapse' => null,
					'item-name' => 'asdf',
				]
			],
		];
	}
}
