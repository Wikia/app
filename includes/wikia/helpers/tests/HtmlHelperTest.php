<?php
class HtmlHelperTest extends WikiaBaseTest {

	public function setUp() {
		require_once( __DIR__ . '/../HtmlHelper.class.php' );
		parent::setUp();
	}

	/**
	 * @dataProvider testStripAttributesDataProvider
	 */
	public function testStripAttributes( $html, $attribs, $expectedResult ) {
		$this->assertEquals(
			HtmlHelper::stripAttributes( $html, $attribs ),
			$expectedResult
		);
	}

	/**
	 * Some cases were inspired by https://github.com/zendframework/zend-filter/blob/master/test/StripTagsTest.php
	 *
	 * @return array
	 */
	public function testStripAttributesDataProvider() {
		return [
			[
				'<a style="color: black">text</a>',
				[ 'style' ],
				'<a>text</a>',
				'Strips attribute from the black list'
			],
			[
				'<a href="#" style="color: black">text</a>',
				[ 'href', 'style' ],
				'<a>text</a>',
				'Strips multiple attributes from the black list'
			],
			[
				'<a href="#" style="color: black">text</a>',
				[ 'style' ],
				'<a href="#">text</a>',
				'Does not strip attributes which are not on the black list'
			],
			[
				'<a hReF="#">text</a>',
				[ 'href' ],
				'<a>text</a>',
				'Strips attributes regardless of casing'
			],
			[
				'<a href="#1">text1</a><a href="#2">text2</a>',
				[ 'href' ],
				'<a>text1</a><a>text2</a>',
				'Strips attributes from successive tags'
			],
			[
				'<div style="color: black"><a href="#">text</a></div>',
				[ 'href', 'style' ],
				'<div><a>text</a></div>',
				'Strips attributes from nested tags'
			],
			[
				'<a href=#>text</a>',
				[ 'href' ],
				'<a>text</a>',
				'Strips attributes that have value not wrapped in quotes'
			],
			[
				'<a href="#">text</a>',
				[],
				'<a href="#">text</a>',
				'Does not strip anything if the black list is empty'
			]
		];
	}
}
