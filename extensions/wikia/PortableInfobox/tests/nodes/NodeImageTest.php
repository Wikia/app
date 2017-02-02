<?php

class NodeImageTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeImage::getGalleryData
	 */
	public function testGalleryData() {
		$input = '<div data-model="[{&quot;caption&quot;:&quot;_caption_&quot;,&quot;title&quot;:&quot;_title_&quot;}]"></div>';
		$expected = [
			[
				'label' => '_caption_',
				'title' => '_title_',
			]
		];
		$this->assertEquals( $expected, Wikia\PortableInfobox\Parser\Nodes\NodeImage::getGalleryData( $input ) );
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeImage::getTabberData
	 */
	public function testTabberData() {
		$input = '<div class="tabber"><div class="tabbertab" title="_title_"><p><a><img data-image-key="_data-image-key_"></a></p></div></div>';
		$expected = [
			[
				'label' => '_title_',
				'title' => '_data-image-key_',
			]
		];
		$this->assertEquals( $expected, Wikia\PortableInfobox\Parser\Nodes\NodeImage::getTabberData( $input ) );
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeImage::getMarkers
	 * @dataProvider markersProvider
	 * @param $ext
	 * @param $value
	 * @param $expected
	 */
	public function testMarkers( $ext, $value, $expected ) {
		$this->assertEquals( $expected, Wikia\PortableInfobox\Parser\Nodes\NodeImage::getMarkers( $value, $ext ) );
	}

	public function markersProvider() {
		return [
			[
				'TABBER',
				"<div>\x7f'\"`UNIQ123456789-tAbBeR-12345678-QINU`\"'\x7f</div>",
				[ "\x7f'\"`UNIQ123456789-tAbBeR-12345678-QINU`\"'\x7f" ]
			],
			[
				'GALLERY',
				"\x7f'\"`UNIQ123456789-tAbBeR-12345678-QINU`\"'\x7f<center>\x7f'\"`UNIQabcd-gAlLeRy-12345678-QINU`\"'\x7f</center>\x7f'\"`UNIQabcd-gAlLeRy-87654321-QINU`\"'\x7f",
				[ "\x7f'\"`UNIQabcd-gAlLeRy-12345678-QINU`\"'\x7f", "\x7f'\"`UNIQabcd-gAlLeRy-87654321-QINU`\"'\x7f" ]
			]
		];
	}


	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeImage::getData
	 * @dataProvider dataProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testData( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->getData() );
	}

	public function dataProvider() {
		// markup, params, expected
		return [
			[
				'<image source="img"></image>',
				[ ],
				[ [ 'url' => '', 'name' => '', 'key' => '', 'alt' => null, 'caption' => null, 'isVideo' => false ] ]
			],
			[
				'<image source="img"></image>',
				[ 'img' => 'test.jpg' ],
				[ [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => null, 'caption' => null, 'isVideo' => false ] ]
			],
			[
				'<image source="img"><alt><default>test alt</default></alt></image>',
				[ 'img' => 'test.jpg' ],
				[ [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => 'test alt', 'caption' => null, 'isVideo' => false ] ]
			],
			[
				'<image source="img"><alt source="alt source"><default>test alt</default></alt></image>',
				[ 'img' => 'test.jpg', 'alt source' => 2 ],
				[ [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => 2, 'caption' => null, 'isVideo' => false ] ]
			],
			[
				'<image source="img"><alt><default>test alt</default></alt><caption source="img"/></image>',
				[ 'img' => 'test.jpg' ],
				[ [ 'url' => '', 'name' => 'Test.jpg', 'key' => 'Test.jpg', 'alt' => 'test alt', 'caption' => 'test.jpg', 'isVideo' => false ] ]
			],
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeImage::isEmpty
	 * @dataProvider isEmptyProvider
	 *
	 * @param $markup
	 * @param $params
	 * @param $expected
	 */
	public function testIsEmpty( $markup, $params, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, $params );

		$this->assertEquals( $expected, $node->isEmpty() );
	}

	public function isEmptyProvider() {
		return [
			[ '<image></image>', [ ], true ],
		];
	}

	/**
	 * @covers       \Wikia\PortableInfobox\Parser\Nodes\NodeImage::getSources
	 * @dataProvider sourcesProvider
	 *
	 * @param $markup
	 * @param $expected
	 */
	public function testSources( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->getSources() );
	}

	public function sourcesProvider() {
		return [
			[
				'<image source="img"/>',
				[ 'img' ]
			],
			[
				'<image source="img"><default>{{{img}}}</default><alt source="img" /></image>',
				[ 'img' ]
			],
			[
				'<image source="img"><alt source="alt"/><caption source="cap"/></image>',
				[ 'img', 'alt', 'cap' ]
			],
			[
				'<image source="img"><alt source="alt"><default>{{{def}}}</default></alt><caption source="cap"/></image>',
				[ 'img', 'alt', 'def', 'cap' ] ],
			[
				'<image/>',
				[ ]
			],
			[
				'<image source="img"><caption source="cap"><format>Test {{{cap}}} and {{{fcap}}}</format></caption></image>',
				[ 'img', 'cap', 'fcap' ]
			]
		];
	}

	/** @dataProvider metadataProvider */
	public function testMetadata( $markup, $expected ) {
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->getMetadata() );
	}

	public function metadataProvider() {
		return [
			[
				'<image source="img"><caption source="cap"><format>Test {{{cap}}} and {{{fcap}}}</format></caption></image>',
				[ 'type' => 'image', 'sources' => [
					'img' => [ 'label' => '', 'primary' => true ],
					'cap' => [ 'label' => '' ],
					'fcap' => [ 'label' => '' ]
				] ]
			]
		];
	}

	/**
	 * @dataProvider testVideoProvider
	 * @param $markup
	 * @param $params
	 * @param $expected
	 * @throws \Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException
	 */
	public function testVideo( $markup, $params, $expected ) {
		$fileMock = new FileMock();
		$xmlObj = Wikia\PortableInfobox\Parser\XmlParser::parseXmlString( $markup );

		$this->mockStaticMethod( 'WikiaFileHelper', 'getFileFromTitle', $fileMock );
		$nodeImage = new Wikia\PortableInfobox\Parser\Nodes\NodeImage( $xmlObj, $params );

		$this->assertEquals( $expected, $nodeImage->getData() );
	}

	public function testVideoProvider() {
		return [
			[
				'<image source="img" />',
				[ 'img' => 'test.jpg' ],
				[
					[
						'url' => 'http://test.url',
						'name' => 'Test.jpg',
						'key' => 'Test.jpg',
						'alt' => null,
						'caption' => null,
						'isVideo' => true,
						'duration' => '00:10'
					]
				]
			]
		];
	}
}

class FileMock {
	public function getMediaType() {
		return "VIDEO";
	}

	public function getMetadataDuration() {
		return 10;
	}

	public function getUrl() {
		return '';
	}

	public function getTitle() {
		return new TitleMock();
	}
}

class TitleMock {
	public function getFullURL() {
		return 'http://test.url';
	}
}
