<?php
use Wikia\Util\GlobalStateWrapper;

class TemplateCleanupTest extends WikiaBaseTest {

	/** @var GlobalStateWrapper */
	private $globals;

	public function setUp() {
		parent::setUp();
		$this->globals = new GlobalStateWrapper(
			[ 'wgEnableEmptySectionsCleanup' => true, 'wgArticleAsJson' => true ] );
	}

	/**
	 * @dataProvider snippetsDataProvider
	 */
	public function testEmptyHeadersCleaner( $html, $expected ) {
		$this->globals->wrap( function () use ( &$html ) {
			TemplateCleanup::doCleanup( null, $html );
		} );

		$this->assertEquals( $expected, $html );
	}

	public function snippetsDataProvider() {
		return [
			[ "", "" ],
			[ "<h2>test</h2>", "" ],
			[ "<h2>test</h2>\n<p>jaskdjfkl sdafjlkjds</p>", "<h2>test</h2>\n<p>jaskdjfkl sdafjlkjds</p>" ],
			[ "<h2>test</h2>\njaskdjfkl sdafjlkjds", "<h2>test</h2>\njaskdjfkl sdafjlkjds" ],
			[ "<p>testing single paragraph</p>", "<p>testing single paragraph</p>" ],
			[ "<h2>test kjl</h2>\n<p>testing paragraph</p><h2>test</h2>\n<h3>test2</h3>",
			  "<h2>test kjl</h2>\n<p>testing paragraph</p>\n" ],
			[ "<p>test</p>\n<h2>1</h2>\n<p>asdf</p>\n<h2>sd</h2>\n<h3>asdkfjlks</h3>\n<h3>aksdjflk</h3>\n<p>asdkfjlkadjf</p>",
			  "<p>test</p>\n<h2>1</h2>\n<p>asdf</p>\n<h2>sd</h2>\n\n<h3>aksdjflk</h3>\n<p>asdkfjlkadjf</p>" ],
		];
	}
}
