<?php

class PortableInfoboxBuilderServiceTest extends WikiaBaseTest {

	/**
	 * @var PortableInfoboxBuilderService
	 */
	private $builderService;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfoboxBuilder.setup.php';
		parent::setUp();
		$this->builderService = new PortableInfoboxBuilderService();
	}

	protected function tearDown() {
		parent::tearDown();
		libxml_clear_errors();
	}

	/**
	 * @dataProvider dataTranslationsDataProvider
	 */
	public function testTranslationFromData( $data, $expected ) {
		$this->assertEquals( $expected, $this->builderService->translateDataToMarkup( $data, false ) );
	}

	/**
	 * @dataProvider markupTranslationsDataProvider
	 */
	public function testTranslationFromMarkup( $markup, $expected ) {
		// we are encoding and decoding here to be able to easly compare two structures. json_encode works
		// differently according to context where object/array is placed and thus, A' != json_decode(json_encode(A))
		// Other solution would be to build proper stdClass structure in $expected field but that would require
		// much more work and would decrease readability.
		$generated_json = json_decode( json_encode( $this->builderService->translateMarkupToData( $markup ) ) );
		$expected_json = json_decode( $expected );
		$this->assertEquals( $expected_json, $generated_json );
	}

	/**
	 * @dataProvider markupSupportDataProvider
	 */
	public function testMarkupSupport( $markup, $expected, $message ) {
		$this->assertEquals( $expected, $this->builderService->isSupportedMarkup( $markup ), $message );
	}

	/**
	 * @dataProvider infoboxArrayValidityDataProvider
	 */
	public function testInfoboxArrayValidity( $array, $isSupportedMarkupReturnValue, $expected, $message ) {
		$builderServiceMock = $this->getMockBuilder( 'PortableInfoboxBuilderService' )
			->setMethods( [ 'isSupportedMarkup' ] )
			->getMock();
		$builderServiceMock
			->expects( $this->any() )
			->method( 'isSupportedMarkup' )
			->willReturn( $isSupportedMarkupReturnValue );

		$this->assertEquals( $expected, $builderServiceMock->isValidInfoboxArray( $array ), $message );
	}

	/**
	 * @dataProvider updateInfoboxProvider
	 */
	public function testUpdateInfobox( $data, $expected ) {
		$this->assertEquals( $expected, $this->builderService->updateInfobox( $data[ 'oldInfobox' ], $data[ 'newInfobox' ], $data[ 'oldContent' ] ) );
	}

	/**
	 * @dataProvider updateDocumentationProvider
	 */
	public function testUpdateDocumentation( $data, $expected ) {
		$this->assertEquals( $expected, $this->builderService->updateDocumentation( $data[ 'oldDoc' ],
			$data[ 'newDoc' ], $data[ 'oldContent' ] ) );
	}


	public function infoboxArrayValidityDataProvider() {
		return [
			[ [ ], false, true, 'Empty infobox array is valid' ],
			[ [ 'infobox1' ], true, true, 'Array with single supported infobox is valid' ],
			[ [ 'infobox1', 'infobox2' ], true, false, 'Array with more than one infobox (even supported) is not valid' ],
			[ [ 'infobox1' ], false, false, 'Array with single unsupported infobox is not valid' ],
		];
	}

	public function dataTranslationsDataProvider() {
		return [
			[ "", "" ],
			[ "[]", "" ],
			[ '{"data":[{"type":"row", "source":"asdf"}]}', '<infobox><data source="asdf"/></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": "asdfsda"}}]}', '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": "Tom & Jerry"}}]}', '<infobox><data source="asdf"><label>Tom &amp; Jerry</label></data></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": ""}}]}', '<infobox><data source="asdf"/></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "{{PAGENAME}}"}}]}', '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": ""}}]}', '<infobox><title source="title"/></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "0"}}]}', '<infobox><title source="title"><default>0</default></title></infobox>' ],
			[
				'{"data": [{"data": {"defaultValue": ""},"source": "title1","type": "title"},{"data": {"caption": {"source": "caption1"}},"source": "image1","type": "image"},{"data": {"label": "Label 1"},"source": "row1","type": "row"},{"data": {"label": "Label 2"},"source": "row2","type": "row"},{"data": "Header 1","type": "section-header"},{"data": {"label": "Label 3"},"source": "row3","type": "row"},{"data": "Header 2","type": "section-header"},{"data": {"caption": {"source": "caption2"}},"source": "image2","type": "image"},{"data": "Header 3","type": "section-header"},{"data": {"label": "Label 4"},"source": "row4","type": "row"},{"data": {"defaultValue": ""},"source": "title2","type": "title"},{"data": "Header 4","type": "section-header"},{"data": {"caption": {"source": "caption3"}},"source": "image3","type": "image"},{"data": {"defaultValue": ""},"source": "title3","type": "title"}]}',
				'<infobox><title source="title1"/><image source="image1"><caption source="caption1"/></image><data source="row1"><label>Label 1</label></data><data source="row2"><label>Label 2</label></data><group><header>Header 1</header><data source="row3"><label>Label 3</label></data></group><group><header>Header 2</header><image source="image2"><caption source="caption2"/></image></group><group><header>Header 3</header><data source="row4"><label>Label 4</label></data></group><title source="title2"/><group><header>Header 4</header><image source="image3"><caption source="caption3"/></image></group><title source="title3"/></infobox>'
			],
			[
				'{"data": [{"type": "section-header", "data": "some fancy header", "collapsible": true}, {"type":"row", "source":"asdf"}]}',
				'<infobox><group collapse="open"><header>some fancy header</header><data source="asdf"/></group></infobox>'
			],
			[
				'{"data": [{"type": "section-header", "data": "some fancy header", "collapsible": false}, {"type":"row", "source":"asdf"}]}',
				'<infobox><group><header>some fancy header</header><data source="asdf"/></group></infobox>'
			],
			[
				'{"data": [{"type": "section-header", "data": "some fancy header", "collapsible": false}, {"type":"row", "source":"asdf"}, {"type": "section-header", "data": "some fancy header", "collapsible": true}, {"type":"row", "source":"asdf"}]}',
				'<infobox><group><header>some fancy header</header><data source="asdf"/></group><group collapse="open"><header>some fancy header</header><data source="asdf"/></group></infobox>'
			],
			[
				'{"data":[{"type":"row", "source":"asdf"}],"theme":""}',
				'<infobox theme=""><data source="asdf"/></infobox>'
			],
			[
				'{"data":[{"type":"row", "source":"asdf"}],"theme":"europa"}',
				'<infobox theme="europa"><data source="asdf"/></infobox>'
			],
			[
				'{"data":[{"type":"row", "source":"行を使用するとイン"}]}',
				'<infobox><data source="行を使用するとイン"/></infobox>'
			],
			[
				'{"data":[{"type":"row", "source":"!żźć∂śśĻó^"}]}',
				'<infobox><data source="!żźć∂śśĻó^"/></infobox>'
			]
		];
	}

	public function markupTranslationsDataProvider() {
		return [
			[ "", "{}" ],
			[ '<infobox><data source="asdf"/></infobox>', '{"data":[{"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>', '{"data":[{"type":"row", "source":"asdf", "data": {"label": "asdfsda"}}]}' ],
			[ '<infobox><data source="asdf"><label>Tom &amp; Jerry</label></data></infobox>', '{"data":[{"type":"row", "source":"asdf", "data": {"label": "Tom & Jerry"}}]}' ],
			[ '<infobox><data source="asdf"/></infobox>', '{"data":[{"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><group><header>some fancy header</header><data source="asdf"/></group></infobox>', '{"data": [{"type": "section-header", "data": "some fancy header", "collapsible": false}, {"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><group collapse="open"><header>some fancy header</header><data source="asdf"/></group></infobox>', '{"data": [{"type": "section-header", "data": "some fancy header", "collapsible": true}, {"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><group collapse="close"><header>some fancy header</header><data source="asdf"/></group></infobox>', '{"data": [{"type": "section-header", "data": "some fancy header", "collapsible": false}, {"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>', '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "{{PAGENAME}}"}}]}' ],
			[ '<infobox><title source="title"/></infobox>', '{"data":[{"type":"title", "source":"title"}]}' ],
			[ '<infobox><title source="title"><default>0</default></title></infobox>', '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "0"}}]}' ],
			[
				'<infobox><title source="title1"/><image source="image1"><caption source="caption1"/></image><data source="row1"><label>Label 1</label></data><data source="row2"><label>Label 2</label></data><image source="image2"><caption source="caption2"/></image><image source="image3"><caption source="caption3"/></image></infobox>',
				'{"data":[{"source":"title1","type":"title"},{"data":{"caption":{"source":"caption1"}},"source":"image1","type":"image"},{"data":{"label":"Label 1"},"source":"row1","type":"row"},{"data":{"label":"Label 2"},"source":"row2","type":"row"},{"data":{"caption":{"source":"caption2"}},"source":"image2","type":"image"},{"data":{"caption":{"source":"caption3"}},"source":"image3","type":"image"}]}'
			],
			[
				'<infobox><title source="title1"/><image source="image1"><caption source="caption1"/></image><data source="row1"><label>Label 1</label></data><data source="row2"><label>Label 2</label></data><group><header>Header 1</header><data source="row3"><label>Label 3</label></data></group><group><header>Header 2</header><image source="image2"><caption source="caption2"/></image></group><group><header>Header 3</header><data source="row4"><label>Label 4</label></data></group><title source="title2"/><group><header>Header 4</header><image source="image3"><caption source="caption3"/></image></group><title source="title3"/></infobox>',
				'{"data": [{"source": "title1","type": "title"},{"data": {"caption": {"source": "caption1"}},"source": "image1","type": "image"},{"data": {"label": "Label 1"},"source": "row1","type": "row"},{"data": {"label": "Label 2"},"source": "row2","type": "row"},{"data": "Header 1","type": "section-header", "collapsible": false},{"data": {"label": "Label 3"},"source": "row3","type": "row"},{"data": "Header 2","type": "section-header", "collapsible": false},{"data": {"caption": {"source": "caption2"}},"source": "image2","type": "image"},{"data": "Header 3","type": "section-header", "collapsible": false},{"data": {"label": "Label 4"},"source": "row4","type": "row"},{"source": "title2","type": "title"},{"data": "Header 4","type": "section-header", "collapsible": false},{"data": {"caption": {"source": "caption3"}},"source": "image3","type": "image"},{"source": "title3","type": "title"}]}'
			],
			[
				'<infobox theme=""><data source="asdf"/></infobox>',
				'{"data":[{"type":"row", "source":"asdf"}],"theme":""}'
			],
			[
				'<infobox><data source="asdf"/></infobox>',
				'{"data":[{"type":"row", "source":"asdf"}]}'
			],
			[
				'<infobox theme="europa"><data source="asdf"/></infobox>',
				'{"data":[{"type":"row", "source":"asdf"}],"theme":"europa"}'
			]
		];
	}

	public function markupSupportDataProvider() {
		return [
			[ "", false, "empty text should not be supported" ],
			[ '<infobox/>', true, "empty infobox should be supported" ],
			[ '<infobox></infobox>', true, "empty infobox should be supported" ],
			[ 'Invalid text detected <^', false, "non-xml should not be supported" ],
			[ '<infobox><data source="asdf"/></infobox>', true, "data tag should be supported" ],
			[ '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>', true, "data tag with label should be supported" ],
			[ '<infobox><data source="asdf"><label>[[some link]]</label></data></infobox>', true, "links within labels should be supported" ],
			[ '<infobox><data source="asdf"><label>{{template}} and rest of label</label></data></infobox>', true, "wikitext is supported within labels" ],
			[ '<infobox><data source="asdf"><label>\'\'\'some text\'\'\'</label></data></infobox>', true, "wikitext is supported within labels" ],
			[ '<infobox><data source="asdf"><label source="label_source">asdfsda</label></data></infobox>', false, "source is not valid attrib for label" ],
			[ '<infobox><data source="asdf"/></infobox>', true, "data tag should be supported" ],
			[ '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>', true, "{{PAGENAME}} is supported within title" ],
			[ '<infobox><title source="title"><default>  {{PAGENAME}}  </default></title></infobox>', true, "{{PAGENAME}} is supported within title" ],
			[ '<infobox><title source="title"><default>some strange title default</default></title></infobox>', false, "default tag is not supported within title" ],
			[ '<infobox><title source="title"/></infobox>', true, "title tag is supported" ],
			[ '<infobox><title source="title"><default>0</default></title></infobox>', false, "default tag is not supported within title" ],
			[ '<infobox><group><data source="asdf"/></group></infobox>', false, "group without header is not supported" ],
			[ '<infobox><group><header>asdf</header></group></infobox>', true, "group with header is supported" ],
			[ '<infobox><group><header></header></group></infobox>', true, "group with empty header is supported" ],
			[ '<infobox><group><header>hd</header><data source="asdf"/></group></infobox>', true, "group with header and data is supported" ],
			[ '<infobox><group collapse="open"><header>hd</header><data source="asdf"/></group></infobox>', true, "collapse=open is supported attrib in group" ],
			[ '<infobox><group collapse="false"><header>hd</header><data source="asdf"/></group></infobox>', false, "collapse=close is not supported attrib in group" ],
			[ '<infobox theme="asdf"><image source="image"><alt source="title"><default>asdf</default></alt></image></infobox>', false, "default within image is not supported" ],
			[ '<infobox theme="adsf"><group><header>asdf</header></group></infobox>', false, "user theme is not supported attrib" ],
			[ '<infobox><title source="title1"/><image source="image1"><caption source="caption1"/></image><data source="row1"><label>Label 1</label></data><data source="row2"><label>Label 2</label></data><group><header>Header 1</header><data source="row3"><label>Label 3</label></data></group><group><header>Header 2</header><image source="image2"><caption source="caption2"/></image></group><group><header>Header 3</header><data source="row4"><label>Label 4</label></data></group><title source="title2"/><group><header>Header 4</header><image source="image3"><caption source="caption3"/></image></group><title source="title3"/></infobox>', true, "" ],
			[ '<infobox theme=""><data source="asdf"/></infobox>', true, "empty theme is supported value" ],
			[ '<infobox theme="europa"><data source="asdf"/></infobox>', false, "europa theme is not supported value" ],
			[ '<infobox theme="other"><data source="asdf"/></infobox>', false, "other theme is not supported value" ],
		];
	}

	public function updateInfoboxProvider() {
		return [
			[
				[
					"oldInfobox" => '<infobox><data source="asdf"/></infobox>',
					"newInfobox" => '<infobox><data source="something_different"/><data source="something_different2"/></infobox>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content'
				], '<infobox><data source="something_different"/><data source="something_different2"/></infobox>\n other non infobox content'
			],
			[
				[
					"oldInfobox" => '<infobox><data source="asdf123"/></infobox>',
					"newInfobox" => '<infobox><data source="something_different"/><data source="something_different2"/></infobox>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content <noinclude>some doc</noinclude>'
				], '<infobox><data source="asdf"/></infobox>\n other non infobox content <noinclude>some doc</noinclude>'
			],
			[
				[
					"oldInfobox" => '<infobox><data source="asdf"/></infobox>',
					"newInfobox" => '<infobox><data source="asdf"/></infobox>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content <noinclude>some doc</noinclude>'
				], '<infobox><data source="asdf"/></infobox>\n other non infobox content <noinclude>some doc</noinclude>'
			],
			[
				[
					"oldInfobox" => '',
					"newInfobox" => '<infobox><data source="asdf"/></infobox>',
					"oldContent" => 'other non infobox content <noinclude>some doc</noinclude>'
				], 'other non infobox content <noinclude>some doc</noinclude>'
			]
		];
	}

	public function updateDocumentationProvider() {
		return [
			[
				[
					"oldDoc" => '<pre>{{Poiu|title1=my title;}}</pre>',
					"newDoc" => '<pre>{{Poiu|awesome_title=my title;}}</pre>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
				], '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|awesome_title=my title;}}</pre>'
			],
			[
				[
					"oldDoc" => '<pre>{{Poiu|title2=my title;}}</pre>',
					"newDoc" => '<pre>{{Poiu|awesome_title=my title;}}</pre>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
				], '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
			],
			[
				[
					"oldDoc" => '<pre>{{Poiu|title1=my title;}}</pre>',
					"newDoc" => '<pre>{{Poiu|title1=my title;}}</pre>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
				], '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
			],
			[
				[
					"oldDoc" => '',
					"newDoc" => '<pre>{{Poiu|title1=my title;}}</pre>',
					"oldContent" => '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
				], '<infobox><data source="asdf"/></infobox>\n other non infobox content <pre>{{Poiu|title1=my title;}}</pre>'
			]
		];
	}
}
