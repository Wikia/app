<?php

class UnconvertedInfoboxesPageTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Insights.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getInfoboxTitles
	 */
	public function testIsTitleWithNonportableInfobox( $titleText, $contentText, $expected ) {
		$result = UnconvertedInfoboxesPage::isTitleWithNonportableInfobox( $titleText, $contentText );
		$this->assertSame( $expected, $result );
	}

	public function getInfoboxTitles() {
		return [
			[
				'This is a portable Infobox title',
				'This is the thing we are looking for: <infobox>',
				false
			],
			[
				'This is a non-portable Infobox title',
				'This content misses an infobox XML-like tag',
				true
			],
			[
				'This is an ignored Infobox documentation title/docs',
				'This content is irrelevant and will be ignored',
				false
			],
			[
				'This is a title with no word in-fo-box in it, but with a non-portable one in the content',
				'{| class="infobox" style="width: 20em; text-align: left; font-size: 95%;"
				| style="background: #9400D3; font-size: 110%;" align="center" colspan="2" |
				|-
				| style="background: #9400D3; color: #FFFFFF; font-size: 110%;" align="center" colspan="2" | {{{name}}}
				|-
				|{{#if:{{{image|}}} | colspan="2" style="text-align:center;" {{!}} {{{image}}}
				|}}',
				true
			],
			[
				'This is a neutral title',
				'<div class="foobar">This template is used on an infobox <span class="bar"></span></div>',
				false
			],
		];
	}
}
