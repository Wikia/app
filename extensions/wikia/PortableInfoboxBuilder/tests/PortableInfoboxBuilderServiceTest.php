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
		$generated_json = json_decode($this->builderService->translateMarkupToData( $markup ));
		$expected_json = json_decode($expected);
		$this->assertEquals( $expected_json, $generated_json );
	}

	/**
	 * @dataProvider markupSupportDataProvider
	 */
	public function testMarkupSupport( $markup, $expected ) {
		$this->assertEquals( $expected, $this->builderService->isSupportedMarkup( $markup ) );
	}

	/**
	 * @dataProvider updateInfoboxProvider
	 */
	public function testUpdateInfobox($data, $expected) {
		$this->assertEquals( $expected, $this->builderService->updateInfobox($data['oldInfobox'], $data['newInfobox'], $data['oldContent']));
	}

	/**
	 * @dataProvider updateDocumentationProvider
	 */
	public function testUpdateDocumentation($data, $expected) {
		$this->assertEquals( $expected, $this->builderService->updateDocumentation($data['oldDoc'],
			$data['newDoc'], $data['oldContent']));
	}

	public function dataTranslationsDataProvider() {
		return [
			[ "", "" ],
			[ "[]", "" ],
			[ '{"data":[{"type":"row", "source":"asdf"}]}', '<infobox><data source="asdf"/></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": "asdfsda"}}]}', '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": ""}}]}', '<infobox><data source="asdf"/></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "{{PAGENAME}}"}}]}', '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": ""}}]}', '<infobox><title source="title"/></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "0"}}]}', '<infobox><title source="title"><default>0</default></title></infobox>' ],
			[
				'{"data": [{"data": {"defaultValue": ""},"source": "title1","type": "title"},{"data": {"caption": {"source": "caption1"}},"source": "image1","type": "image"},{"data": {"label": "Label 1"},"source": "row1","type": "row"},{"data": {"label": "Label 2"},"source": "row2","type": "row"},{"data": "Header 1","type": "section-header"},{"data": {"label": "Label 3"},"source": "row3","type": "row"},{"data": "Header 2","type": "section-header"},{"data": {"caption": {"source": "caption2"}},"source": "image2","type": "image"},{"data": "Header 3","type": "section-header"},{"data": {"label": "Label 4"},"source": "row4","type": "row"},{"data": {"defaultValue": ""},"source": "title2","type": "title"},{"data": "Header 4","type": "section-header"},{"data": {"caption": {"source": "caption3"}},"source": "image3","type": "image"},{"data": {"defaultValue": ""},"source": "title3","type": "title"}]}',
				'<infobox><title source="title1"/><image source="image1"><caption source="caption1"/></image><data source="row1"><label>Label 1</label></data><data source="row2"><label>Label 2</label></data><group><header>Header 1</header><data source="row3"><label>Label 3</label></data></group><group><header>Header 2</header><image source="image2"><caption source="caption2"/></image></group><group><header>Header 3</header><data source="row4"><label>Label 4</label></data></group><title source="title2"/><group><header>Header 4</header><image source="image3"><caption source="caption3"/></image></group><title source="title3"/></infobox>'
			]
		];
	}

	public function markupTranslationsDataProvider() {
		return [
			[ "", "[]" ],
			[ '<infobox><data source="asdf"/></infobox>', '{"data":[{"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>', '{"data":[{"type":"row", "source":"asdf", "data": {"label": "asdfsda"}}]}' ],
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
			]
		];
	}

	public function markupSupportDataProvider() {
		return [ [ "", false ],
			[ '<infobox><data source="asdf"/></infobox>', true ],
			[ '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>', true ],
			[ '<infobox><data source="asdf"><label>[[some link]]</label></data></infobox>', true ],
			[ '<infobox><data source="asdf"><label>{{template}} and rest of label</label></data></infobox>', true ],
			[ '<infobox><data source="asdf"><label>\'\'\'some text\'\'\'</label></data></infobox>', true ],
			[ '<infobox><data source="asdf"><label source="label_source">asdfsda</label></data></infobox>', false ],
			[ '<infobox><data source="asdf"/></infobox>', true ],
			[ '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>', true ],
			[ '<infobox><title source="title"><default>  {{PAGENAME}}  </default></title></infobox>', true ],
			[ '<infobox><title source="title"><default>some strange title default</default></title></infobox>', false ],
			[ '<infobox><title source="title"/></infobox>', true ],
			[ '<infobox><title source="title"><default>0</default></title></infobox>', false ],
			[ '<infobox><group><data source="asdf"/></group></infobox>', false ],
			[ '<infobox theme="asdf"><image source="image"><alt source="title"><default>asdf</default></alt></image></infobox>', false ],
			[ '<infobox theme="adsf"><group><header>asdf</header></group></infobox>', false ],
			[ '<infobox><title source="title1"/><image source="image1"><caption source="caption1"/></image><data source="row1"><label>Label 1</label></data><data source="row2"><label>Label 2</label></data><group><header>Header 1</header><data source="row3"><label>Label 3</label></data></group><group><header>Header 2</header><image source="image2"><caption source="caption2"/></image></group><group><header>Header 3</header><data source="row4"><label>Label 4</label></data></group><title source="title2"/><group><header>Header 4</header><image source="image3"><caption source="caption3"/></image></group><title source="title3"/></infobox>', true ]
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
