<?php
require_once( dirname( __FILE__ ) . '/../LyricsWikiCrawler.php' );

class LyricsWikiCrawlerTest extends WikiaBaseTest {

	/**
	 * @param String $message
	 * @param Array $input
	 * @param Array $expected
	 *
	 * @dataProvider convertIntoArtistPagesDataProvider
	 */
	public function testConvertIntoArtistPages( $message, $input, $expected ) {
		$crawler = $this->getMock( 'LyricsWikiCrawler', [ 'getArtistPageId' ] );
		$crawler->expects( $this->any() )
			->method( 'getArtistPageId' )
			->will( $this->returnValue( 131 ) );

		$this->assertEquals( $expected, $crawler->convertIntoArtistPages( $input ), $message );
	}

	public function convertIntoArtistPagesDataProvider() {
		return [
			[
				'empty array passed',
				[],
				[]
			],
			[
				'only artist pages passed',
				[ (object)[ 'id' => 123, 'category' => 'Artist' ], (object)[ 'id' => 456, 'category' => 'Artist' ], (object)[ 'id' => 789, 'category' => 'Artist' ] ],
				[ 123, 456, 789 ],
			],
			[
				'only artist pages passed - case sensitiveness check',
				[ (object)[ 'id' => 123, 'category' => 'Artist' ], (object)[ 'id' => 456, 'category' => 'artist' ], (object)[ 'id' => 789, 'category' => 'ArTiSt' ] ],
				[ 123, 456, 789 ],
			],
			[
				'different pages passed',
				[ (object)[ 'id' => 123, 'category' => 'Artist' ], (object)[ 'id' => 101, 'category' => 'Album' ], (object)[ 'id' => 112, 'category' => 'Song' ] ],
				[ 123, 131 ],
			],
		];
	}

}
