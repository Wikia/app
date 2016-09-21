<?php
use Wikia\Util\GlobalStateWrapper;

class ArticleHTMLCleanupTest extends WikiaBaseTest {

	/** @var GlobalStateWrapper */
	private $globals;

	public function setUp() {
		parent::setUp();
		$this->globals = new GlobalStateWrapper(
			[ 'wgEnableMercuryHtmlCleanup' => true, 'wgArticleAsJson' => true ] );
	}

	/**
	 * @dataProvider snippetsDataProvider
	 */
	public function testEmptyHeadersCleaner( $html, $expected ) {
		$this->globals->wrap( function () use ( &$html ) {
			ArticleHTMLCleanup::doCleanup( null, $html );
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
			  "<h2>test kjl</h2>\n<p>testing paragraph</p>" ],
			[ "<p>test</p>\n<h2>1</h2>\n<p>asdf</p>\n<h2>sd</h2>\n<h3>asdkfjlks</h3>\n<h3>aksdjflk</h3>\n<p>asdkfjlkadjf</p>",
			  "<p>test</p>\n<h2>1</h2>\n<p>asdf</p>\n<h2>sd</h2>\n<h3>aksdjflk</h3>\n<p>asdkfjlkadjf</p>" ],
			// you should be aware of that
			[ "<ul><li> 1\n</li><li> 2\n</li><li> 3\n</li></ul>", "<ul>\n<li> 1\n</li>\n<li> 2\n</li>\n<li> 3\n</li>\n</ul>" ],
			[ "<h1>1</h1><h2>2</h2><h3>3</h3><h4>4</h4><h2>5</h2>", "" ],
			[ "<h2>1</h2>\n<p> </p>\n<h2>2</h2>\n<p><br/></p>\n<h2>3</h2>\n<p>asdfdf</p>", "<h2>3</h2>\n<p>asdfdf</p>" ],
		];
	}
}
