<?php

class PortableInfoboxParsingHelperTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testsProvider
	 */
	public function testParsingIncludeonlyInfoboxes( $markup, $expected ) {
		$helper = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxParsingHelper' )
			->setMethods( [ 'fetchArticleContent' ] )->getMock();
		$helper->expects( $this->once() )->method( 'fetchArticleContent' )->will( $this->returnValue( $markup ) );

		$result = $helper->parseIncludeonlyInfoboxes( new Title() );

		$this->assertEquals( $expected, $result );
	}

	public function testsProvider() {
		return [
			[ 'test', false ],
			[
				'<includeonly><infobox><data source="test"><label>1</label></data></infobox></includeonly>',
				[
					[
						'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
						'data' => [],
						'metadata' => [
							[
								'type' => 'data',
								'sources' => [
									'test' => [
										'label' => '1',
										'primary' => true
									]
								]
							]
						]
					]
				]
			],
			[ '<includeonly></includeonly><infobox></infobox>', false ],
			[
				'<includeonly><infobox></infobox></includeonly> ',
				[
					[
						'parser_tag_version' => PortableInfoboxParserTagController::PARSER_TAG_VERSION,
						'data' => [],
						'metadata' => []
					]
				]
			],
			[ '<nowiki><includeonly><infobox></infobox></includeonly></nowiki>', false ],
			[ '<includeonly><nowiki><infobox></infobox></nowiki></includeonly>', false ],
		];
	}
}
