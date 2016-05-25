<?php
/**
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author macbre
 * @group Integration
 * @group MediaFeatures
 */
class ImageServingIndexerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../imageServing.setup.php';
		parent::setUp();
	}

	/**
	 * test function ImageServingHelper::buildIndex
	 *
	 * This test assumes that:
	 *  - "Main Page" article
	 *  - "Wiki-wordmark.png" image
	 *  - "FireflyLogo-NoBackground.png" image
	 * exist on a wiki this test is run for
	 *
	 * @see ImageServingHelper::buildIndex
	 * @dataProvider buildIndexProvider
	 */
	public function testBuildIndex($wikitext, $expectedImages) {
		$title = Title::newFromText('Main Page');
		$article = new Article($title);

		// mock article's content
		$article->mContent = $wikitext;
		$article->mContentLoaded = true;

		// disable access to the database
		$this->getMethodMock('DatabaseMysqlBase','replace');
		$this->getMethodMock('Database','delete');

		// mock wgTitle needed by RedirectsService
		$this->mockGlobalVariable( 'wgTitle', $title );

		$images = ImageServingHelper::buildAndGetIndex($article);
		$this->assertEquals($expectedImages, $images, 'List of images matches expected ones');
	}

	public function buildIndexProvider() {
		return [
			// thumbnail
			[
				'wikitext' => '[[File:Wiki-wordmark.png|thumb]]',
				'expectedImages' => ['Wiki-wordmark.png']
			],
			// repeated image
			[
				'wikitext' => '[[File:Wiki-wordmark.png|thumb]][[File:Wiki-wordmark.png|thumb]]',
				'expectedImages' => ['Wiki-wordmark.png', 'Wiki-wordmark.png']
			],
			// gallery
			[
				'wikitext' => '<gallery>Wiki-wordmark.png</gallery>',
				'expectedImages' => ['Wiki-wordmark.png']
			],
			// tabber
			[
				'wikitext' => "<tabber>\n 1 = [[File:Wiki-wordmark.png|250px]]\n|-|\n 2 = [[File:FireflyLogo-NoBackground.png|250px]]\n</tabber>",
				'expectedImages' => ['Wiki-wordmark.png', 'FireflyLogo-NoBackground.png']
			],
			// more images
			[
				'wikitext' => '[[File:Wiki-wordmark.png|thumb]][[File:FireflyLogo-NoBackground.png|thumb]]',
				'expectedImages' => ['Wiki-wordmark.png', 'FireflyLogo-NoBackground.png']
			],
			// images order is kept
			[
				'wikitext' => '[[File:FireflyLogo-NoBackground.png|thumb]][[File:Wiki-wordmark.png|thumb]]',
				'expectedImages' => ['FireflyLogo-NoBackground.png', 'Wiki-wordmark.png']
			],
			[
				'wikitext' => "<gallery>\nWiki-wordmark.png\nFireflyLogo-NoBackground.png\n</gallery>",
				'expectedImages' => ['Wiki-wordmark.png', 'FireflyLogo-NoBackground.png']
			],
			[
				'wikitext' => "<gallery>\nImage:Wiki-wordmark.png\nFile:FireflyLogo-NoBackground.png\n</gallery>",
				'expectedImages' => ['Wiki-wordmark.png', 'FireflyLogo-NoBackground.png']
			],
			// gallery and thumb
			[
				'wikitext' => "<gallery>Wiki-wordmark.png</gallery>\n\nFoo bar\n\n[[File:FireflyLogo-NoBackground.png|thumb]]",
				'expectedImages' => ['Wiki-wordmark.png', 'FireflyLogo-NoBackground.png']
			],
			// not existing image
			[
				'wikitext' => '[[File:NotExistsingImage728653576123.png|thumb]]',
				'expectedImages' => []
			],
			// not existing and existing image
			[
				'wikitext' => '[[File:NotExistsingImage728653576123.png|thumb]][[File:Wiki-wordmark.png|thumb]]',
				'expectedImages' => ['Wiki-wordmark.png']
			],
			// no images
			[
				'wikitext' => 'Foo bar',
				'expectedImages' => []
			]
		];
	}
}
