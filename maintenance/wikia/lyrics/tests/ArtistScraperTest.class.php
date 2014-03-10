<?php
class ArtistScraperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../lyrics.setup.php';
		parent::setUp();
	}

	/**
	 * @desc Tests ArtistScraper::testGetHeader()
	 *
	 * @dataProvider processArticleDataProvider
	 */
	public function testProcessArticle( $message, $expected, $mockedTitleText, $mockedArticleId, $mockedArticleContent ) {
		$titleMock = $this->getMock( 'Title', [ 'getText' ], [], '', false );
		$titleMock->expects( $this->once() )
			->method( 'getText' )
			->will( $this->returnValue( $mockedTitleText ) );

		$articleMock = $this->getMock( 'Article', [ 'getId', 'getTitle', 'getContent' ], [], '', false );
		$articleMock->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( $mockedArticleId ) );
		$articleMock->expects( $this->once() )
			->method( 'getTitle' )
			->will( $this->returnValue( $titleMock ) );
		$articleMock->expects( $this->any() )
			->method( 'getContent' )
			->will( $this->returnValue( $mockedArticleContent ) );

		$artistScraper = new ArtistScraper();
		$this->assertEquals( $expected, $artistScraper->processArticle( $articleMock ), $message );
	}

	public function processArticleDataProvider() {
		return [
			[
				'message' => 'No matches found',
				'expected' => [
					'article_id' => 123,
					'name' => 'Test',
					'image' => '',
					'itunes' => '',
					'genres' => [],
				],
				'mockedTitleText' => 'Test',
				'mockedArticleId' => 123,
				'mockedArticleContent' => '',
			],
		];
	}

	/**
	 * @desc Tests ArtistScraper::getSections() method
	 *
	 * @dataProvider getSectionsDataProvider
	 */
	public function testGetSections( $message, $text, $expected ) {
		$artistScraper = new ArtistScraper();
		$this->assertEquals( $expected, $artistScraper->getSections( $text ), $message );
	}

	public function getSectionsDataProvider() {
		return [
			[
				'message' => 'Empty text',
				'text' => '',
				'expected' => [],
			],
			[
				'message' => 'One section as a content',
				'text' => '== A section ==',
				'expected' => [
					'== A section =='
				],
			],
			[
				'message' => 'More than one section as a content with different variations of whitespaces',
				'text' => <<<WIKITEXT
==First section==
Text, text, text.
== Second section==
Text, text, text.
==Third section ==
Text, text, text.
==     Fourth   section    ==
Text, text, text.
WIKITEXT
,
				'expected' => [
					0 =>
						<<<WIKITEXT
==First section==
Text, text, text.

WIKITEXT
,
					1 => <<<WIKITEXT
== Second section==
Text, text, text.

WIKITEXT
					,
					2 => <<<WIKITEXT
==Third section ==
Text, text, text.

WIKITEXT
					,
					3 => <<<WIKITEXT
==     Fourth   section    ==
Text, text, text.
WIKITEXT
					,
				],
			],
		];
	}

}
