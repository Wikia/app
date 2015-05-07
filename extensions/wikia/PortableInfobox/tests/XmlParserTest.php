<?php

class XmlParserTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	public function testIsEmpty() {
		$parser = new \Wikia\PortableInfobox\Parser\XmlParser( [
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA',
			'nonempty' => '111'
		]);
		$markup = '
			<infobox>
				<comparison>
				   <set>
					  <header>Combatientes</header>
					  <data source="lado1" />
					  <data source="lado2" />
				   </set>
				</comparison>
				<data source="empty" />
				<data source="nonempty"><label>nonemepty</label></data>
			</infobox>
		';
		$data = $parser->getDataFromXmlString( $markup );
		$this->assertTrue( $data[0]['data']['value'][0]['data']['value'][0]['data']['value'] == 'Combatientes' );
		// '111' should be at [1] position, becasue <data source="empty"> should be ommited
		$this->assertTrue( $data[1]['data']['value'] == '111' );
	}

	public function testExternalParser() {
		$parser = new \Wikia\PortableInfobox\Parser\XmlParser( [
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA'
		] );
		$externalParser = new \Wikia\PortableInfobox\Parser\DummyParser();
		$parser->setExternalParser( $externalParser );
		$markup = '
			<infobox>
			    <title><default>ABB</default></title>
				<comparison>
				   <set>
					  <header>Combatientes</header>
					  <data source="lado1" />
					  <data source="lado2" />
				   </set>
				</comparison>
				<footer>[[aaa]]</footer>
			</infobox>
		';
		$data = $parser->getDataFromXmlString( $markup );
		$this->assertTrue( $data[0]['data']['value'] == 'parseRecursive(ABB)' );
		// ledo1 ommited, ledo2 at [1] position
		$this->assertTrue( $data[1]['data']['value'][0]['data']['value'][1]['data']['value'] == 'parseRecursive(LALALA)');
	}
}
