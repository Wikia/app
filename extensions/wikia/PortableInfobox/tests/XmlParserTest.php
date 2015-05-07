<?php

class XmlParserTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	public function testIsEmpty() {
		$parser = new \Wikia\PortableInfobox\Parser\XmlParser( [
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA'
		] );
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
		$this->assertFalse( $data[ 0 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ][ 0 ][ 'isEmpty' ] );
		// infobox -> comparison -> set -> data { lado1 }
		$this->assertTrue( $data[ 0 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ][ 1 ][ 'isEmpty' ] );
		// infobox -> comparison -> set -> data { lado2 }
		$this->assertFalse( $data[ 0 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ][ 2 ][ 'isEmpty' ] );
		// infobox -> comparison -> set
		$this->assertFalse( $data[ 0 ][ 'data' ][ 'value' ][ 0 ][ 'isEmpty' ] );
		// infobox -> comparison
		$this->assertFalse( $data[ 0 ][ 'isEmpty' ] );
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
		$this->assertEquals( 'parseRecursive(ABB)', $data[ 0 ][ 'data' ][ 'value' ] );
		$this->assertEquals( 'parseRecursive(LALALA)',
			$data[ 1 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ][ 2 ][ 'data' ][ 'value' ] );
	}
}
