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
	public function testAddIfNotExists( $inputs, $expected ) {
		$results = [];

		foreach( $inputs as $input ) {
			$this->crawler->addIfNotExists( $results, $input );
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

	/**
	 * @dataProvider groupByTypeDataProvider
	 */
	public function testGroupByType( $inputs, $expected ) {
		$this->assertEquals( $expected, $this->crawler->groupByType( $inputs ) );
	}

	public function groupByTypeDataProvider() {
		return [
			[
				'inputs' => [],
				'expected' => [ 'updates' => [], 'deletes' => [] ],
			],
			[
				'inputs' => [
					839788 => [ 'rc_cur_id' => 839788, 'rc_deleted' => 0 ],
					839789 => [ 'rc_cur_id' => 839789, 'rc_deleted' => 0 ],
					839790 => [ 'rc_cur_id' => 839790, 'rc_deleted' => 0 ]
				],
				'expected' => [
					'updates' => [
						839788 => [ 'rc_cur_id' => 839788, 'rc_deleted' => 0 ],
						839789 => [ 'rc_cur_id' => 839789, 'rc_deleted' => 0 ],
						839790 => [ 'rc_cur_id' => 839790, 'rc_deleted' => 0 ],
					],
					'deletes' => []
				],
			],
			[
				'inputs' => [
					839788 => [ 'rc_cur_id' => 839788, 'rc_deleted' => 0 ],
					839789 => [ 'rc_cur_id' => 839789, 'rc_deleted' => 1 ],
					839790 => [ 'rc_cur_id' => 839790, 'rc_deleted' => 2 ]
				],
				'expected' => [
					'updates' => [
						839788 => [ 'rc_cur_id' => 839788, 'rc_deleted' => 0 ],
					],
					'deletes' => [
						839789 => [ 'rc_cur_id' => 839789, 'rc_deleted' => 1 ],
						839790 => [ 'rc_cur_id' => 839790, 'rc_deleted' => 2 ],
					]
				],
			],
		];
	}

}
