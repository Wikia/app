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

	/**
	 * @param string $type
	 * @param string $changedTemplateText
	 *
	 * @dataProvider shouldChangeTemplateParsingDataProvider
	 */
	public function testShouldChangeTemplateParsing( $type, $changedTemplateText ) {
		$text = self::TEST_TEMPLATE_TEXT;
		$title = $this->getMock( 'Title' );

		$this->mockClassWithMethods(
			'ExternalTemplateTypesProvider',
			[ 'getTemplateTypeFromTitle' => $type ]
		);

		$this->mockGlobalVariable( 'wgCityId', '12345' );
		$this->mockGlobalVariable( 'wgEnableTemplateTypesParsing', true );
		$this->mockGlobalVariable( 'wgArticleAsJson', true );

		TemplateTypesParser::onFetchTemplateAndTitle( $text, $title );

		$this->assertEquals( $text, $changedTemplateText );
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

	public function shouldChangeTemplateParsingDataProvider() {
		return [
			[
				'navbox',
				''
			],
			[
				'reference',
				'<references />'
			],
			[
				'references',
				'<references />'
			]
		];
	}

	/**
	 * @param $contextLinkWikitext
	 * @param $expectedTemplateWikiext
	 *
	 * @dataProvider sanitizeContextLinkWikitextDataProvider
	 */
	public function testSanitizeContextLinkWikitext( $contextLinkWikitext, $expectedTemplateWikiext ) {
		$sanitizedTemplateWikiext = TemplateTypesParser::sanitizeContextLinkWikitext( $contextLinkWikitext );

		$this->assertEquals( $sanitizedTemplateWikiext, $expectedTemplateWikiext );
	}

	public function sanitizeContextLinkWikitextDataProvider() {
		return [
			[
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]',
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]'
			],
			[
				'* [[Let\'s see powerrangers]] - \'\'[[Super Sentai]]\'\' counterpart
in \'\'[[and some more crazy stuff!]]\'\'.\'\'',
				'[[Let\'s see powerrangers]] - [[Super Sentai]] counterpart in [[and some more crazy stuff!]].'
			],
			[
				':\'\'Italics [[Foo Bar]] - [[foo|here]]\'\'.',
				'Italics [[Foo Bar]] - [[foo|here]].',
			],
			[
				'   \'\'\'Bold [[Foo Bar]] - [[foo|here]] with spaces\'\'\'.',
				'Bold [[Foo Bar]] - [[foo|here]] with spaces.',
			],
			[
				'===Headers [[Foo Bar]]=== - [[foo|here]] in context-links*!.',
				'Headers [[Foo Bar]] - [[foo|here]] in context-links*!.'
			],
			[
				'===Headers [[Foo Bar]]====>[[foo|here]] in context-links*!.',
				'Headers [[Foo Bar]]=>[[foo|here]] in context-links*!.'
			]
		];
	}

	/**
	 * @param array $templateAgrs
	 * @param string $longestVal
	 *
	 * @dataProvider getTemplateArgsLongestValDataProvider
	 */
	public function testGetTemplateArgsLongestVal( $templateAgrs, $longestVal ) {
		$this->assertEquals( TemplateTypesParser::getTemplateArgsLongestVal( $templateAgrs ), $longestVal );
	}

	public function getTemplateArgsLongestValDataProvider() {
		return [
			[
				[
					'aaaaa',
					'aaa',
					'a'
				],
				'aaaaa',
			],
			[
				[
					'aaaaa',
					'',
				],
				'aaaaa',
			],
			[
				[
					'aaaaa'
				],
				'aaaaa',
			],
			[
				[
					'aaaaa1',
					'aaaaa2'
				],
				'aaaaa1',
			],
			[
				[
					'',
					''
				],
				'',
			]
		];
	}
}
