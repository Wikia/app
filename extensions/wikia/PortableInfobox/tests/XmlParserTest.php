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
		$this->assertTrue( $data[1]['data']['value'][0]['data']['value'][2]['data']['value'] == 'parseRecursive(LALALA)');
	}

	/**
	 * @dataProvider errorHandlingDataProvider
	 */
	public function testErrorHandling( $markup, $expectedErrors ) {

		$this->setExpectedException( '\Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException' );

		$parser = $this->getMockBuilder( 'Wikia\PortableInfobox\Parser\XmlParser' )
						->setConstructorArgs( [ [] ] )
						->setMethods( [ 'logXmlParseError' ] )
						->getMock();

		foreach ( $expectedErrors as $i => $expectedError ) {
			$parser->expects( $this->at( $i ) )->method( 'logXmlParseError' )->with( $expectedError['level'],
																					 $expectedError['code'],
																					 $expectedError['msg'] );
		}

		$data = $parser->getDataFromXmlString( $markup );
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
						['level' => LIBXML_ERR_FATAL, 'code' => 73, 'msg' => "expected '>'"],
						['level' => LIBXML_ERR_FATAL, 'code' => 76, 'msg' => "Opening and ending tag mismatch: data line 1 and dat"],
						['level' => LIBXML_ERR_FATAL, 'code' => 5, 'msg' => "Extra content at the end of the document"],
					]
				],
				[
					'<data> x </data></data>',
					[
						['level' => LIBXML_ERR_FATAL, 'code' => 5, 'msg' => "Extra content at the end of the document"],
					]
				],
				[
					'<data> > ddd < a ></data>',
					[
						['level' => LIBXML_ERR_FATAL, 'code' => 68, 'msg' => "StartTag: invalid element name"],
					]
				],
				[
					'<data>',
					[
						['level' => LIBXML_ERR_FATAL, 'code' => 77, 'msg' => "Premature end of data in tag data line 1"],
					]
				],
				[
					'<infobox><data source=caption></infobox>',
					[
						['level' => LIBXML_ERR_FATAL, 'code' => 39, 'msg' => "AttValue: \" or ' expected"],
						['level' => LIBXML_ERR_FATAL, 'code' => 65, 'msg' => "attributes construct error"],
						['level' => LIBXML_ERR_FATAL, 'code' => 73, 'msg' => "Couldn't find end of Start Tag data line 1"],
					]
				],
				[
					'<infobox><data source="caption"></infobox>',
					[
						['level' => LIBXML_ERR_FATAL, 'code' => 76, 'msg' => "Opening and ending tag mismatch: data line 1 and infobox"],
					]
				],
				[
					'<infobox><data source="caption></data></infobox>',
					[
						['level' => LIBXML_ERR_FATAL, 'code' => 38, 'msg' => "Unescaped '<' not allowed in attributes values"],
						['level' => LIBXML_ERR_FATAL, 'code' => 65, 'msg' => "attributes construct error"],
						['level' => LIBXML_ERR_FATAL, 'code' => 73, 'msg' => "Couldn't find end of Start Tag data line 1"],
						['level' => LIBXML_ERR_FATAL, 'code' => 76, 'msg' => "Opening and ending tag mismatch: infobox line 1 and data"],
						['level' => LIBXML_ERR_FATAL, 'code' => 5, 'msg' => "Extra content at the end of the document"]
					]
				]
		];
	}
}
