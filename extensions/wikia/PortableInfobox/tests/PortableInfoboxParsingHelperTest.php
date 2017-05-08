<?php
use PHPUnit\Framework\TestCase;

class PortableInfoboxParsingHelperTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../services/Helpers/PortableInfoboxParsingHelper.php';
	}

	/**
	 * @dataProvider parsingIncludeonlyInfoboxesDataProvider
	 */
	public function testParsingIncludeonlyInfoboxes( $markup, $expected ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|\Wikia\PortableInfobox\Helpers\PortableInfoboxParsingHelper $helper */
		$helper = $this->getMockBuilder( \Wikia\PortableInfobox\Helpers\PortableInfoboxParsingHelper::class )
			->setMethods( [ 'fetchArticleContent' ] )
			->getMock();
		$helper->expects( $this->once() )
			->method( 'fetchArticleContent' )
			->willReturn( $markup );

		$result = $helper->parseIncludeonlyInfoboxes( new Title() );

		$this->assertEquals( $expected, $result );
	}

	public function parsingIncludeonlyInfoboxesDataProvider() {
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
