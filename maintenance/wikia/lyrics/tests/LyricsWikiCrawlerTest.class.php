<?php
class LyricsWikiCrawlerTest extends WikiaBaseTest {

	public function setUp() {
		require_once( dirname( __FILE__ ) . '/../LyricsWikiCrawler.php' );
		parent::setUp();
	}

	/**
	 * @dataProvider addIfNotExistsDataProvider
	 */
	public function testAddIfNotExists( $inputs, $expected ) {
		$crawler = new LyricsWikiCrawler();
		$results = [];

		foreach( $inputs as $input ) {
			$crawler->addIfNotExists( $results, $input );
		}

		$this->assertEquals( $expected, $results );
	}

	public function addIfNotExistsDataProvider() {
		return [
			[
				'inputs' => [],
				'expected' => [],
			],
			[
				'inputs' => [ [ 'rc_cur_id' => 839788 ], [ 'rc_cur_id' => 839789 ], [ 'rc_cur_id' => 839790 ] ],
				'expected' => [ 839788 => [ 'rc_cur_id' => 839788 ], 839789 => [ 'rc_cur_id' => 839789 ], 839790 => [ 'rc_cur_id' => 839790 ] ],
			],
			[
				'inputs' => [ [ 'rc_cur_id' => 839788, 'the newest' ], [ 'rc_cur_id' => 839788, 'older' ], [ 'rc_cur_id' => 839788, 'the oldest' ] ],
				'expected' => [ 839788 => [ 'rc_cur_id' => 839788, 'the newest' ] ],
			],
		];
	}

}
