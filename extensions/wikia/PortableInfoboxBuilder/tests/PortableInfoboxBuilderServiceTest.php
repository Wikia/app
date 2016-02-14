<?php

class PortableInfoboxBuilderServiceTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfoboxBuilder.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider translationsDataProvider
	 */
	public function testTranslation( $data, $expected ) {
		$service = new PortableInfoboxBuilderService();

		$this->assertEquals( $expected, $service->translate( $data ) );
	}

	public function translationsDataProvider() {
		return [
			[ "", "" ],
			[ "[]", "" ],
			[ '{"data":[{"type":"row", "source":"asdf"}]}', '<infobox><data source="asdf"/></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": "asdfsda"}}]}',
			  '<infobox><data source="asdf"><label>asdfsda</label></data></infobox>' ],
			[ '{"data":[{"type":"row", "source":"asdf", "data": {"label": ""}}]}',
				'<infobox><data source="asdf"/></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": "{{PAGENAME}}"}}]}',
			  '<infobox><title source="title"><default>{{PAGENAME}}</default></title></infobox>' ],
			[ '{"data":[{"type":"title", "source":"title", "data": {"defaultValue": ""}}]}',
				'<infobox><title source="title"/></infobox>' ],
			[ '{"data":[{"type":"group", "data": [{"type": "row", "source": "asdf"}]}]}',
			  '<infobox><group><data source="asdf"/></group></infobox>' ],
			[ '{"theme": "asdf", "data": [{"type": "image", "source": "image", "data": { "alt": {"source": "title", "data": {"default": "asdf"}}}}]}',
			  '<infobox theme="asdf"><image source="image"><alt source="title"><default>asdf</default></alt></image></infobox>' ],
			[ '{"theme": "adsf", "data": [{"type": "group", "data": [{"type":"header", "data":"asdf"}]}]}',
			  '<infobox theme="adsf"><group><header>asdf</header></group></infobox>' ]
		];
	}
}
