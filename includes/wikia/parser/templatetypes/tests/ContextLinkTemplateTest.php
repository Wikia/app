<?php

class ContextLinkTemplateTest extends WikiaBaseTest {
	/**
	 * @param $contextLinkWikitext
	 * @param $expectedTemplateWikiext
	 *
	 * @dataProvider sanitizeContextLinkWikitextDataProvider
	 */
	public function testSanitizeContextLinkWikitext( $contextLinkWikitext, $expectedTemplateWikiext ) {
		$sanitizedTemplateWikiext = ContextLinkTemplate::sanitizeContextLinkWikitext( $contextLinkWikitext );

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
			],
			[
				'# Collaborative encyclopedia for everything related to [[The Sims]]
# series',
				'Collaborative encyclopedia for everything related to [[The Sims]] series'
			]
		];
	}
}
