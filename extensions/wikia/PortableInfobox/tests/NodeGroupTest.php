<?php
class NodeGroupTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testGetDataDataProvider
	 */
	public function testGetData( $val1, $val2, $string, $expectedOutput ) {
		$xml = simplexml_load_string( $string );
		$node = new Wikia\PortableInfobox\Parser\Nodes\NodeGroup( $xml, [ 'val1' => $val1, 'val2' => $val2 ] );
		$data = $node->getData();
		$this->assertEquals( $expectedOutput['layout'], $data['layout'] );
	}

	public function testGetDataDataProvider() {
		return [
			[
				'val1' => 'damage',
				'val2' => 'prize',
				'string' => '<group layout="horizontal">
						<header>Weapon Characteristics</header>
							<data source="val1">
								<label>Weapon damage</label>
							</data>
					</group>',
				'expectedOutput' => [
					'value' => '',
					'layout' => 'horizontal'
				]
			],
			[
				'val1' => 'damage',
				'val2' => 'prize',
				'string' => '<group>
						<header>Weapon Characteristics</header>
							<data source="val1">
								<label>Weapon damage</label>
						</data>
					</group>',
				'expectedOutput' => [
					'value' => '',
					'layout' => 'default'
				]
			],
			[
				'val1' => 'damage',
				'val2' => 'prize',
				'string' => '<group layout="horizontal">
						<header>Weapon Characteristics</header>
							<data source="val1">
								<label>Weapon damage</label>
						</data>
						<data source="val2">
								<label>Weapon prize</label>
						</data>
					</group>',
				'expectedOutput' => [
					'value' => '',
					'layout' => 'horizontal'
				]
			],
		];
	}
}
