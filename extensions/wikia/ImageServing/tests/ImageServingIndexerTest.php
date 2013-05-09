<?php
/**
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author macbre
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
		$this->mockGlobalFunction('GetDB', $this->mockClassWithMethods('Database', [
			'replace' => null,
			'delete' => null
		]));
		$this->mockApp();

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
