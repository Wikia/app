<?php

class InfoiconTemplateTest extends WikiaBaseTest {
	/**
	 * @param $infoiconWikitext
	 * @param $expectedTemplateWikiext
	 *
	 * @dataProvider testHandleDataProvider
	 */
	public function testHandle( $infoiconWikitext, $expectedTemplateWikiext ) {
		$sanitizedTemplateWikiext = InfoiconTemplate::handle( $infoiconWikitext );

		$this->assertEquals( $sanitizedTemplateWikiext, $expectedTemplateWikiext );
	}

	public function testHandleDataProvider() {
		return [
			[
				'[[:Harry Potter]]',
				'[[:Harry Potter]]'
			],
			[
				'[[Tryndamere]]was the first champion with 100 [[Image:points]] in
Attack Rating[[File:Spinning Slash]]!',
				'[[Image:points]] [[File:Spinning Slash]]'
			],
			[
				'[[Image:money]]',
				'[[Image:money]]',
			]
		];
	}
}
