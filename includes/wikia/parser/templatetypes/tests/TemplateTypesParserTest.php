<?php

class TemplateTypesParserTest extends WikiaBaseTest
{
	const TEST_TEMPLATE_TEXT = 'test-template-test';

	/**
	 * @param $enableTemplateTypesParsing
	 * @param $wgArticleAsJson
	 *
	 * @dataProvider shouldNotChangeTemplateParsingDataProvider
	 */
	public function testShouldNotChangeTemplateParsing( $enableTemplateTypesParsing, $wgArticleAsJson )
	{
		$text = self::TEST_TEMPLATE_TEXT;
		$title = $this->getMock( 'Title' );

		$this->mockClassWithMethods(
			'ExternalTemplateTypesProvider',
			[ 'getTemplateTypeFromTitle' => '' ]
		);

		$this->mockGlobalVariable( 'wgCityId', '12345' );
		$this->mockGlobalVariable( 'wgEnableTemplateTypesParsing', $enableTemplateTypesParsing );
		$this->mockGlobalVariable( 'wgArticleAsJson', $wgArticleAsJson );


		TemplateTypesParser::onFetchTemplateAndTitle( $text, $title );

		$this->assertEquals( $text, self::TEST_TEMPLATE_TEXT );
	}

	public function testShouldRemoveNavboxTemplateText()
	{
		$text = self::TEST_TEMPLATE_TEXT;
		$title = $this->getMock( 'Title' );

		$this->mockClassWithMethods(
			'ExternalTemplateTypesProvider',
			[ 'getTemplateTypeFromTitle' => 'navbox' ]
		);

		$this->mockGlobalVariable( 'wgCityId', '12345' );
		$this->mockGlobalVariable( 'wgEnableTemplateTypesParsing', true );
		$this->mockGlobalVariable( 'wgArticleAsJson', true );

		TemplateTypesParser::onFetchTemplateAndTitle( $text, $title );

		$this->assertEquals( $text, '' );
	}

	public function shouldNotChangeTemplateParsingDataProvider() {
		return [
			[
				false,
				false
			],
			[
				true,
				false
			],
			[
				false,
				true
			]
		];
	}
}
