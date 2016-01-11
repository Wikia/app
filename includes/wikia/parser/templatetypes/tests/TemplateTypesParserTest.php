<?php

class TemplateTypesParserTest extends WikiaBaseTest {
	const TEST_TEMPLATE_TEXT = 'test-template-test';

	/**
	 * @param int $templateId
	 * @param $enableTemplateTypesParsing
	 * @param $wgArticleAsJson
	 *
	 * @dataProvider shouldNotChangeTemplateParsingDataProvider
	 */
	public function testShouldNotChangeTemplateParsing( $templateId, $enableTemplateTypesParsing, $wgArticleAsJson ) {
		$text = self::TEST_TEMPLATE_TEXT;

		$this->mockClassWithMethods(
			'Title',
			[ 'getArticleId' => $templateId ]
		);
		$this->mockClassWithMethods(
			'TemplateClassificationService',
			[ 'getType' => '' ]
		);

		$this->mockGlobalVariable( 'wgCityId', '12345' );
		$this->mockGlobalVariable( 'wgEnableTemplateTypesParsing', $enableTemplateTypesParsing );
		$this->mockGlobalVariable( 'wgArticleAsJson', $wgArticleAsJson );


		TemplateTypesParser::onFetchTemplateAndTitle( $text, $title );

		$this->assertEquals( $text, self::TEST_TEMPLATE_TEXT );
	}

	/**
	 * @param int $templateId
	 * @param string $type
	 * @param string $changedTemplateText
	 *
	 * @dataProvider shouldChangeTemplateParsingDataProvider
	 */
	public function testShouldChangeTemplateParsing( $templateId, $type, $changedTemplateText ) {
		$text = self::TEST_TEMPLATE_TEXT;

		$this->mockClassWithMethods(
				'Title',
				[ 'getArticleId' => $templateId ]
		);

		$this->mockClassWithMethods(
			'TemplateClassificationService',
			[ 'getType' => $type ]
		);

		$this->mockGlobalVariable( 'wgCityId', '12345' );
		$this->mockGlobalVariable( 'wgEnableTemplateTypesParsing', true );
		$this->mockGlobalVariable( 'wgArticleAsJson', true );

		TemplateTypesParser::onFetchTemplateAndTitle( $text, new Title );

		$this->assertEquals( $text, $changedTemplateText );
	}

	public function shouldNotChangeTemplateParsingDataProvider() {
		return [
			[
				1,
				false,
				false
			],
			[
				2,
				true,
				false
			],
			[
				3,
				false,
				true
			]
		];
	}

	public function shouldChangeTemplateParsingDataProvider() {
		return [
			[
				4,
				'navbox',
				''
			],
			[
				5,
				'notice',
				''
			],
			[
				6,
				'references',
				'<references />'
			]
		];
	}
}
