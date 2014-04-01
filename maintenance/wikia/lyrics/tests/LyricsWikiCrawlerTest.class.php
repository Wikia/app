<?php
class LyricsWikiCrawlerTest extends WikiaBaseTest {

	/**
	 * @var LyricsWikiCrawler
	 */
	private $crawler;

	public function setUp() {
		require_once( dirname( __FILE__ ) . '/../LyricsWikiCrawler.php' );
		parent::setUp();
		$this->crawler = new LyricsWikiCrawler();
	}

	/**
	 * @dataProvider addIfNotExistsDataProvider
	 */
	public function testAddIfNotExists( $message, $inputs, $expected ) {
		$results = [];

		foreach( $inputs as $input ) {
			$this->crawler->addIfNotExists( $results, $input );
		}

		$this->assertEquals( $expected, $results, $message );
	}

	public function addIfNotExistsDataProvider() {
		return [
			[
				'empty inputs',
				'inputs' => [],
				'expected' => [],
			],
			[
				'not empty inputs all different',
				'inputs' => [ [ 'rc_cur_id' => 839788 ], [ 'rc_cur_id' => 839789 ], [ 'rc_cur_id' => 839790 ] ],
				'expected' => [ 839788 => [ 'rc_cur_id' => 839788 ], 839789 => [ 'rc_cur_id' => 839789 ], 839790 => [ 'rc_cur_id' => 839790 ] ],
			],
			[
				'not empty inputs all different but one invalid id === 0',
				'inputs' => [ [ 'rc_cur_id' => 0 ], [ 'rc_cur_id' => 839789 ], [ 'rc_cur_id' => 839790 ] ],
				'expected' => [ 839789 => [ 'rc_cur_id' => 839789 ], 839790 => [ 'rc_cur_id' => 839790 ] ],
			],
			[
				'three changes of the same id - take newest (first one)',
				'inputs' => [ [ 'rc_cur_id' => 839788, 'the newest' ], [ 'rc_cur_id' => 839788, 'older' ], [ 'rc_cur_id' => 839788, 'the oldest' ] ],
				'expected' => [ 839788 => [ 'rc_cur_id' => 839788, 'the newest' ] ],
			]
		];
	}

}
