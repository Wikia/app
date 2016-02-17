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
		$this->markTestIncomplete('Feature under development');
		$this->assertEquals( $expected, $this->builderService->translateDataToMarkup( $markup ) );
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
			[ '{"data":[{"type":"group", "data": [{"type": "row", "source": "asdf"}]}]}', '<infobox><group><data source="asdf"/></group></infobox>' ],
			[ '{"theme": "asdf", "data": [{"type": "image", "source": "image", "data": { "alt": {"source": "title", "data": {"default": "asdf"}}}}]}', '<infobox theme="asdf"><image source="image"><alt source="title"><default>asdf</default></alt></image></infobox>' ],
			[ '{"theme": "adsf", "data": [{"type": "group", "data": [{"type":"header", "data":"asdf"}]}]}', '<infobox theme="adsf"><group><header>asdf</header></group></infobox>' ]
		];
	}

	public function markupTranslationsDataProvider() {
		return [
			[ "", "[]" ],
			[ '<infobox><data source="asdf"/></infobox>', '{"data":[{"type":"row", "source":"asdf"}]}' ],
			[ '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>', '{"data":[{"type":"row", "source":"asdf", "data": {"label": "asdfsda"}}]}' ],
			[ '<infobox><data source="asdf"/></infobox>', '{"data":[{"type":"row", "source":"asdf", "data": {"label": ""}}]}' ],
			[ '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>', '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "{{PAGENAME}}"}}]}' ],
			[ '<infobox><title source="title"/></infobox>', '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": ""}}]}' ],
			[ '<infobox><title source="title"><default>0</default></title></infobox>', '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "0"}}]}' ],
			[ '<infobox><group><data source="asdf"/></group></infobox>', '{"data":[{"type":"group", "data": [{"type": "row", "source": "asdf"}]}]}' ],
			[ '<infobox theme="asdf"><image source="image"><alt source="title"><default>asdf</default></alt></image></infobox>', '{"theme": "asdf", "data": [{"type": "image", "source": "image", "data": { "alt": {"source": "title", "data": {"default": "asdf"}}}}]}' ],
			[ '<infobox theme="adsf"><group><header>asdf</header></group></infobox>', '{"theme": "adsf", "data": [{"type": "group", "data": [{"type":"header", "data":"asdf"}]}]}' ]
		];
	}

	public function markupSupportDataProvider() {
		return [
			[ "", false ],
			[ '<infobox><data source="asdf"/></infobox>', true ],
			[ '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>', true ],
			[ '<infobox><data source="asdf"><label source="label_source">asdfsda</label></data></infobox>', false ],
			[ '<infobox><data source="asdf"/></infobox>', true ],
			[ '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>', true ],
			[ '<infobox><title source="title"/></infobox>', true ],
			[ '<infobox><title source="title"><default>0</default></title></infobox>', true ],
			[ '<infobox><group><data source="asdf"/></group></infobox>', false ],
			[ '<infobox theme="asdf"><image source="image"><alt source="title"><default>asdf</default></alt></image></infobox>', false ],
			[ '<infobox theme="adsf"><group><header>asdf</header></group></infobox>', false ]
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
