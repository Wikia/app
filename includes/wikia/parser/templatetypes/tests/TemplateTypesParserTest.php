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
	 * @param string $type
	 * @param $templateWikitext
	 * @param $changedTemplateWikiext
	 * @internal param string $changedTemplateText
	 *
	 * @dataProvider testOnBraceSubstitutionDataProvider
	 */
	public function testOnBraceSubstitution( $type, $templateWikitext, $changedTemplateWikiext ) {
		$text = self::TEST_TEMPLATE_TEXT;
		$title = $this->getMock( 'Title' );

		$this->mockClassWithMethods(
			'ExternalTemplateTypesProvider',
			[ 'getTemplateTypeFromTitle' => $type ]
		);

		$this->mockGlobalVariable( 'wgCityId', '12345' );
		$this->mockGlobalVariable( 'wgEnableTemplateTypesParsing', true );
		$this->mockGlobalVariable( 'wgArticleAsJson', true );

		TemplateTypesParser::onBraceSubstitution( $title, $templateWikitext );

		$this->assertEquals( $templateWikitext, $changedTemplateWikiext );
	}

	public function testOnBraceSubstitutionDataProvider() {
		return [
			[
				'navbox',
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]',
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]',
			],
			[
				'reference',
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]',
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]',
			],
			[
				'other',
				':\'\'\'Ponies in unison\'\'\': What?!',
				':\'\'\'Ponies in unison\'\'\': What?!'
			],
			[
				'context-link',
				'[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]',
				'<div class="' . TemplateTypesParser::CLASS_CONTEXT_LINK . '">[[:Disciplinary hearing of Harry Potter|Disciplinary hearing of Harry Potter]]</div>'
			],
			[
				'context-link',
				'* [[Let\'s see powerrangers]] - \'\'[[Super Sentai]]\'\' counterpart in \'\'[[and some more creazy stuff!]]\'\'.\'\'',
				'<div class="' . TemplateTypesParser::CLASS_CONTEXT_LINK . '">[[Let\'s see powerrangers]] - [[Super Sentai]] counterpart in [[and some more creazy stuff!]].</div>'
			],
			[
				'context-link',
				':\'\'Italics [[Foo Bar]] - [[foo|here]]\'\'.',
				'<div class="' . TemplateTypesParser::CLASS_CONTEXT_LINK . '">Italics [[Foo Bar]] - [[foo|here]].</div>',
			],
			[
				'context-link',
				'   \'\'\'Bold [[Foo Bar]] - [[foo|here]] with spaces\'\'\'.',
				'<div class="' . TemplateTypesParser::CLASS_CONTEXT_LINK . '">Bold [[Foo Bar]] - [[foo|here]] with spaces.</div>',
			]
		];
	}
}
