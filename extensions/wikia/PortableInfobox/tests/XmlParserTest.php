<?php

class XmlParserTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/*
	public function testIsEmpty() {
		$parser = new \Wikia\PortableInfobox\Parser\XmlParser(  );
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
		\Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA',
			'nonempty' => '111'
		] );
		$this->assertTrue( $data[ 0 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ] == 'Combatientes' );
		// '111' should be at [1] position, becasue <data source="empty"> should be ommited
		$this->assertTrue( $data[ 1 ][ 'data' ][ 'value' ] == '111' );
	}

	public function testExternalParser() {
		$externalParser = new \Wikia\PortableInfobox\Parser\DummyParser();
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
		$xml = \Wikia\PortableInfobox\Parser\XmlParser::parseXmlString( $markup );
		$infobox = Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromSimpleXml( $xml, [
			'elem2' => 'ELEM2',
			'lado2' => 'LALALA'
		] );
		$infobox->setExternalParser( $externalParser );
		$data = $infobox->getData()['value'];

		$this->assertTrue( $data[ 0 ][ 'data' ][ 'value' ] == 'parseRecursive(ABB)' );
		// ledo1 ommited, ledo2 at [1] position
		$this->assertTrue( $data[ 1 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ][ 2 ][ 'data' ][ 'value' ] == 'parseRecursive(LALALA)' );
	}

	public function testNotProvidingDataSource() {
		$xmlParser = new \Wikia\PortableInfobox\Parser\XmlParser( [ 'a' => '1' ] );

		$data1 = $xmlParser->getDataFromXmlString( '<infobox><data source="b" /><data source="a" /></infobox>' );
		$this->assertTrue( $data1[ 0 ][ 'data' ][ 'value' ] == '1', 'Data with empty source "b" should be ignored' );
	}

	public function testNotProvidingDataSourceInsideComparison() {
		$xmlParser = new \Wikia\PortableInfobox\Parser\XmlParser( [ 'a' => '1' ] );

		$data1 = $xmlParser->getDataFromXmlString( '<infobox>
														<comparison>
															<set>
																<data source="b" />
																<data source="a" />
															</set>
														</comparison>
													 </infobox>' );

		$setElement = $data1[ 0 ][ 'data' ][ 'value' ][ 0 ][ 'data' ][ 'value' ];

		//Data with empty source "b" should not be ignored inside comparison:
		$this->assertTrue( $setElement[ 0 ][ 'data' ][ 'value' ] == '', 'Data with empty source "b" inside comparison' );
		$this->assertTrue( $setElement[ 0 ][ 'isEmpty' ] == true );

		$this->assertTrue( $setElement[ 1 ][ 'data' ][ 'value' ] == '1', '' );
	}
	*/

	/**
	 * @dataProvider errorHandlingDataProvider
	 */
	public function testErrorHandling( $markup, $expectedErrors ) {
		$parser = $this->getMockBuilder( 'Wikia\PortableInfobox\Parser\XmlParser' )
			->setMethods( [ 'logXmlParseError' ] )
			->getMock();

		$errors = [ ];
		// parseXmlString should throw an exception, but we want to proceed in order to check parameters
		// from logXmlParseError
		try {
			$data = $parser->parseXmlString( $markup, $errors );
		} catch ( \Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException $e ) {
		}

		$this->assertEquals( $expectedErrors, array_map( function ( LibXMLError $error ) {
			return [ 'level' => $error->level, 'code' => $error->code, 'msg' => trim( $error->message ) ];
		}, $errors ) );
	}

	public function errorHandlingDataProvider() {

		/*
		 * Error codes are defined on official xml API documentation:
		 * http://www.xmlsoft.org/html/libxml-xmlerror.html
		 */
		return [
			[
				'<data>d</dat/a>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 73, 'msg' => "expected '>'" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 76, 'msg' => "Opening and ending tag mismatch: data line 1 and dat" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 5, 'msg' => "Extra content at the end of the document" ],
				]
			],
			[
				'<data> x </data></data>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 5, 'msg' => "Extra content at the end of the document" ],
				]
			],
			[
				'<data> > ddd < a ></data>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 68, 'msg' => "StartTag: invalid element name" ],
				]
			],
			[
				'<data>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 77, 'msg' => "Premature end of data in tag data line 1" ],
				]
			],
			[
				'<infobox><data source=caption></infobox>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 39, 'msg' => "AttValue: \" or ' expected" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 65, 'msg' => "attributes construct error" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 73, 'msg' => "Couldn't find end of Start Tag data line 1" ],
				]
			],
			[
				'<infobox><data source="caption"></infobox>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 76, 'msg' => "Opening and ending tag mismatch: data line 1 and infobox" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 77, 'msg' => "Premature end of data in tag infobox line 1" ],
				]
			],
			[
				'<infobox><data source="caption></data></infobox>',
				[
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 38, 'msg' => "Unescaped '<' not allowed in attributes values" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 65, 'msg' => "attributes construct error" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 73, 'msg' => "Couldn't find end of Start Tag data line 1" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 76, 'msg' => "Opening and ending tag mismatch: infobox line 1 and data" ],
					[ 'level' => LIBXML_ERR_FATAL, 'code' => 5, 'msg' => "Extra content at the end of the document" ]
				]
			]
		];
	}
}
