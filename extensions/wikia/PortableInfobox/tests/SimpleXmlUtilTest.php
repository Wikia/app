<?php

class SimpleXmlUtilTest extends WikiaBaseTest {
	private $simpleXmlUtil;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$this->simpleXmlUtil = \Wikia\PortableInfobox\Helpers\SimpleXmlUtil::getInstance();
	}

	/**
	 * @dataProvider testGetInnerXMLDataProvider
	 */
	public function testGetInnerXML( $xmlString, $expValue, $message ) {
		$xml	 = simplexml_load_string( $xmlString );
		$this->assertEquals( $expValue, $this->simpleXmlUtil->getInnerXML( $xml ), $message );
	}

	public function testGetInnerXMLDataProvider() {
		return [
			[
				'<data source="name"><default><gallery orientation="mosaic">TestFile.png</gallery></default></data>',
				'<default><gallery orientation="mosaic">TestFile.png</gallery></default>',
				'Valid gallery tag in default'
			],
			[
				'<data source="name"><default>Test <ref name="multiple" /></default></data>',
				'<default>Test <ref name="multiple"/></default>',
				'Text + XML'
			],
			[
				'<data source="name"><default><ref name="multiple" /></default></data>',
				'<default><ref name="multiple"/></default>',
				'Valid self-closing tag'

			],
			[
				'<data source="name"><default><ref name="multiple" ></default></data>',
				'',
				'Invalid inner XML'
			],
			[
				'<data source="name"><default></data>',
				'',
				'Invalid inner XML'
			],
			[
				'<data source="name" />',
				'',
				'No inner XML'
			]
		];
	}
}
