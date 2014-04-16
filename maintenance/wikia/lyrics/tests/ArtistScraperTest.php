<?php
class ArtistScraperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../lyrics.setup.php';
		parent::setUp();
	}

	/**
	 * @desc Tests the main functionality of scrapers (it's being re-used in all types of scrapers)
	 * @dataProvider getTemplateValuesDataProvider
	 */
	public function testGetTemplateValues( $message, $expected, $name, $text, $separator = '|', $hash = true ) {
		/** @var ArtistScraper $artistScraper */
		$artistScraper = new ArtistScraper();
		$this->assertEquals( $expected, $artistScraper->getTemplateValues( $name, $text, $separator, $hash ), $message );
	}

	public function getTemplateValuesDataProvider() {
		return [
			[
				'message' => 'Default values for optional parameters and rest empty string',
				'expected' => [],
				'name' => '',
				'text' => '',
				'separator' => '',
				'hash' => true,
			],
			[
				'message' => 'Song footer example',
				'expected' => [
					'fLetter' => 'O',
					'album' => 'Dance Of Shadows',
					'song' => 'Only To Love You',
					'language' => 'English',
					'youtube' => '',
					'goear' => '',
					'asin' => '',
					'iTunes' => '',
					'allmusic' => '',
				],
				'name' => 'SongFooter',
				'text' => <<<WIKITEXT
{{SongFooter
|fLetter  = O
|album    = Dance Of Shadows
|song     = Only To Love You
|language = English
|youtube  =
|goear    =
|asin     =
|iTunes   =
|allmusic =
}}
WIKITEXT
,
				'separator' => '|',
				'hash' => true,
			],
			[
				'message' => 'Song footer example with different separator than default',
				'expected' => [],
				'name' => 'SongFooter',
				'text' => <<<WIKITEXT
{{SongFooter
|fLetter  = O
|album    = Dance Of Shadows
|song     = Only To Love You
|language = English
|youtube  =
|goear    =
|asin     =
|iTunes   =
|allmusic =
}}
WIKITEXT
				,
				'separator' => '|#|',
				'hash' => true,
			],
			[
				'message' => 'Different separator than default',
				'expected' => [
					'album' => 'Dance Of Shadows',
					'song' => 'Only To Love You',
					'language' => 'English',
				],
				'name' => 'data',
				'text' => <<<WIKITEXT
{{data
|#|album    = Dance Of Shadows
|#|song     = Only To Love You
|#|language = English
}}
WIKITEXT
				,
				'separator' => '|#|',
				'hash' => true,
			],
			[
				'message' => 'Hash different than default',
				'expected' => [
					'album    = Dance Of Shadows',
					'song     = Only To Love You',
					'language = English',
				],
				'name' => 'Data',
				'text' => <<<WIKITEXT
{{Data
|album    = Dance Of Shadows
|song     = Only To Love You
|language = English
}}
WIKITEXT
				,
				'separator' => '|',
				'hash' => false,
			],
		];
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
					'id' => 123,
					'artist_name' => 'Test',
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

	/**
	 * @desc Tests ArtistScrapper::getAlbumData()
	 * @dataProvider getAlbumDataProvider
	 */
	public function testGetAlbumData( $message, $text, $expected ) {
		$artistScraper = new ArtistScraper();
		$this->assertEquals( $expected, $artistScraper->getAlbumData( $text ), $message );
	}

	public function getAlbumDataProvider() {
		return [
			[
				'message' => 'Empty $text value',
				'text' => '',
				'expected' => [
					'title' => false,
					'Album' => ''
				],
			],
			[
				'message' => 'Valid data',
				'text' => '==[[Entombed:Serpent Saints The Ten Amendments (2007)|Serpent Saints - The Ten Amendments (2007)]]==',
				'expected' => [
					'title' => 'Entombed:Serpent Saints The Ten Amendments (2007)',
					'Album' => 'Serpent Saints - The Ten Amendments',
					'year' => '2007',
				],
			],
			[
				'message' => 'Valid data but without year',
				'text' => '==[[Entombed:Serpent Saints The Ten Amendments|Serpent Saints - The Ten Amendments]]==',
				'expected' => [
					'title' => 'Entombed:Serpent Saints The Ten Amendments',
					'Album' => 'Serpent Saints - The Ten Amendments',
					'year' => '',
				],
			],
			[
				'message' => 'Valid data with UTF-8 characters',
				'text' => '==[[Entombed:Macbreður Hákarlsson (2014)|Macbreður Hákarlsson - The Ten Hákarlsson (2014)]]==',
				'expected' => [
					'title' => 'Entombed:Macbreður Hákarlsson (2014)',
					'Album' => 'Macbreður Hákarlsson - The Ten Hákarlsson',
					'year' => '2014',
				],
			],
			[
				'message' => 'Valid data with UTF-8 characters but the format changed a little bit with whitespaces',
				'text' => '==[[ Entombed : Macbreður Hákarlsson (2014) | Macbreður Hákarlsson - The Ten Hákarlsson (2014) ]]==',
				'expected' => [
					'title' => 'Entombed : Macbreður Hákarlsson (2014)',
					'Album' => 'Macbreður Hákarlsson - The Ten Hákarlsson',
					'year' => '2014',
				],
			],
		];
	}

	/**
	 * @desc Tests ArtistScraper::getAlbumPic() method
	 *
	 * @dataProvider getAlbumPicDataProvider
	 */
	public function testGetAlbumPic( $message, $expected, $text, $artistName ) {
		$artistScraper = new ArtistScraper();
		$this->assertEquals( $expected, $artistScraper->getAlbumPic( $text, $artistName ), $message );
	}

	public function getAlbumPicDataProvider() {
		return [
			[
				'message' => 'Empty template',
				'expected' => '',
				'text' => '{{Album Art}}',
				'artistName' => 'Silent Cry',
			],
			[
				'message' => 'One way of using Album Art template: first parameter is empty so it takes artist name (pagename)',
				'expected' => 'Silent Cry - Goddess of Tears.jpg',
				'text' => '{{Album Art||Goddess of Tears}}',
				'artistName' => 'Silent Cry',
			],
			[
				'message' => 'Second way of using Album Art template: first parameter is NOT empty and it takes it instead of artist name (pagename)',
				'expected' => 'Test - Goddess of Tears.jpg',
				'text' => '{{Album Art|Test|Goddess of Tears}}',
				'artistName' => 'Silent Cry',
			],
		];
	}

	public function testGetAlbumSongsWithEmptySection() {
		$artistScraperStub = $this->getMock( 'ArtistScraper', [ 'getSongData' ] );
		$artistScraperStub->expects( $this->exactly(0) )
			->method( 'getSongData' );
		$this->assertEquals( [], $artistScraperStub->getAlbumSongs( '' ), 'Empty section' );
	}

	/**
	 * @dataProvider getAlbumSongsDataProvider
	 */
	public function testGetAlbumSongs( $message, $expected, $section ) {
		$artistScraperMock = $this->getMock( 'ArtistScraper', [ 'getSongData' ] );
		$artistScraperMock->expects( $this->any() )
			->method( 'getSongData' )
			->will( $this->returnValue( 'song data' ) );
		$this->assertEquals( $expected, $artistScraperMock->getAlbumSongs( $section ), $message );
	}

	public function getAlbumSongsDataProvider() {
		return [
			[
				'Section with an album and songs in ordered list - a whitespace between hash and song link',
				[
					'song data',
					'song data',
					'song data',
					'song data',
					'song data'
				],
				"\n\n==[[NAndy:Test (2014)|Test (2014)]]==\n\n# '''[[NAndy:Test 1|Test 1]]'''\n# '''[[NAndy:Test 1/ru|Test 1/ru]]'''\n# '''[[NAndy:Test 2|Test 2]]'''\n# '''[[NAndy:ROCK|#ROCK]]'''\n# '''[[NAndy:Test 3|Test 3]]'''\n\n\n\n[[Category:Artist]]\n[[Category:NAndy Tests]]",
			],
			[
				'Section with an album and songs in ordered list - no whitespace between hash and song link',
				[
					'song data',
					'song data',
					'song data',
					'song data',
					'song data'
				],
				"\n\n==[[NAndy:Test (2014)|Test (2014)]]==\n\n# '''[[NAndy:Test 1|Test 1]]'''\n#'''[[NAndy:Test 1/ru|Test 1/ru]]'''\n# '''[[NAndy:Test 2|Test 2]]'''\n# '''[[NAndy:ROCK|#ROCK]]'''\n#'''[[NAndy:Test 3|Test 3]]'''\n\n\n\n[[Category:Artist]]\n[[Category:NAndy Tests]]",
			],
			[
				'Section with an album and songs in unordered list',
				[
					'song data',
					'song data',
					'song data',
					'song data',
					'song data'
				],
				"\n\n==[[NAndy:Test (2014)|Test (2014)]]==\n\n* '''[[NAndy:Test 1|Test 1]]'''\n*'''[[NAndy:Test 1/ru|Test 1/ru]]'''\n* '''[[NAndy:Test 2|Test 2]]'''\n* '''[[NAndy:ROCK|#ROCK]]'''\n*'''[[NAndy:Test 3|Test 3]]'''\n\n\n\n[[Category:Artist]]\n[[Category:NAndy Tests]]",
			],
			[
				'Section with an album and songs in mixed lists',
				[
					'song data',
					'song data',
					'song data',
					'song data',
					'song data'
				],
				"\n\n==[[NAndy:Test (2014)|Test (2014)]]==\n\n# '''[[NAndy:Test 1|Test 1]]'''\n*'''[[NAndy:Test 1/ru|Test 1/ru]]'''\n# '''[[NAndy:Test 2|Test 2]]'''\n* '''[[NAndy:ROCK|#ROCK]]'''\n#'''[[NAndy:Test 3|Test 3]]'''\n\n\n\n[[Category:Artist]]\n[[Category:NAndy Tests]]",
			]
		];
	}

}
