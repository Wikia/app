<?php
require_once( dirname( __FILE__ ) . '/../services/Parser/XmlParser.php' );

class TestParser implements \Wikia\PortableInfobox\Parser\ExternalParser {
	public function parse( $text ) {
		return "parse($text)";
	}

	public function parseRecursive( $text ) {
		return "parseRecursive($text)";
	}
}

class XmlParserTest extends WikiaBaseTest {

	protected function setUp() {
		parent::setUp();
		require_once( dirname( __FILE__ ) . '/../PortableInfobox.setup.php' );
	}

	public function testIsEmpty() {
		$parser = new \Wikia\PortableInfobox\Parser\XmlParser([
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA'
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
			</infobox>
		';
		$data = $parser->getDataFromXmlString( $markup );
		// infobox -> comparison -> set -> header
		$this->assertTrue( $data[0]['data']['value'][0]['value'][0]['isEmpty'] == false );
		// infobox -> comparison -> set -> data { lado1 }
		$this->assertTrue( $data[0]['data']['value'][0]['data']['value'][1]['isEmpty'] == true );
		// infobox -> comparison -> set -> data { lado2 }
		$this->assertTrue( $data[0]['data']['value'][0]['data']['value'][2]['isEmpty'] == false );
		// infobox -> comparison -> set
		$this->assertTrue( $data[0]['data']['value']['isEmpty'] == false );
		// infobox -> comparison
		$this->assertTrue( $data[0]['isEmpty'] == false );
	}

	public function testExternalParser() {
		$parser = new \Wikia\PortableInfobox\Parser\XmlParser([
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA'
		]);
		$externalParser = new TestParser();
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
		$this->assertTrue( $data[1]['data']['value'][0]['data']['value'][2]['data']['value'] == 'parseRecursive(LALALA)');
	}
}
