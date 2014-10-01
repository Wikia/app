<?php
include_once dirname( __FILE__ ) . '/../../' . "models/BaseRssModel.class.php";

class DummyModel extends BaseRssModel {
	const LANGUAGE = 'en';
	/**
	 * Ability to switch on/off function for fixing duplicated timestamps
	 */
	protected $testFixDuplicatedTimestamps = false;

	public function setTestFixDuplicatedTimestamps( $testFixDuplicatedTimestamps ) {
		$this->testFixDuplicatedTimestamps = $testFixDuplicatedTimestamps;
	}

	public function getFeedTitle() {
	}

	public function getFeedDescription() {
	}

	protected function loadData( $lastTimestamp, $duplicates ) {
	}

	protected function formatTitle( $item ) {
		return $item;
	}

	/**
	 * Mocked version of getArticleDetail without database calls. Used to test processItems
	 * @param $wid
	 * @param $aid
	 * @return array
	 */
	protected function getArticleDetail( $wid, $aid ) {
		$articles = [
			39778 => [
				2424 => [
					'title' => '300 BATTLE',
					'img' =>
						array (
							'url' => 'http://img2.wikia.nocookie.net/__cb20140625165411/comicshub/images/e/e0/300RoeE_VERS_medrec_330x210.jpg',
							'width' => 330,
							'height' => 210,
						)
				]
			],
			8476 => [
				38393 => [
					'title' => 'Win a Life-Sized Han Solo in Carbonite',
					'img' =>
						array (
							'url' => 'http://img3.wikia.nocookie.net/__cb20140619233829/comicshub/images/d/dd/HanSoloCarbonite.jpg',
							'width' => 454,
							'height' => 363,
						),
				]
			],
			35171 => [
				485877 => [
					'title' => 'Mockingjay Part 1 Teaser Trailer Released',
					'img' =>
						array (
							'url' => 'http://img3.wikia.nocookie.net/__cb20140625182417/movieshub/images/d/da/Movieshub-Mockingjay-Trailer_01.jpg',
							'width' => 300,
							'height' => 258,
						),
				]
			],
			37163 => [
				2737 => [
					'title' => 'Mad Max: Fury Road - First Look: Charlize Theron as Furiosa!',
					'img' =>
						array (
							'url' => 'http://img3.wikia.nocookie.net/__cb20140625212526/movieshub/images/8/84/Movieshub-MADMAX_Furiosa.jpg',
							'width' => 350,
							'height' => 233,
						),
				]
			],
			411 => [
				56636 => [
					'title' => 'Transformers Qwizards',
					'img' =>
						array (
							'url' => 'http://img1.wikia.nocookie.net/__cb20140626012112/comicshub/images/7/7e/QWIZ14_TRANS_Hubslider_330x210.jpg',
							'width' => 330,
							'height' => 210,
						),
				]
			],
			130814 => [
				26914 => [
					'title' => 'GAME OF THRONES Musical Talents',
					'img' =>
						array (
							'url' => 'http://img2.wikia.nocookie.net/__cb20140624211238/musichub/images/d/d3/Screen_Shot_2014-06-24_at_2.11.59_PM.png',
							'width' => 486,
							'height' => 267,
						),
				]
			],
			767908 => [
				2171 => [
					'title' => 'PENTATONIX',
					'img' =>
						array (
							'url' => 'http://img4.wikia.nocookie.net/__cb20140625184430/musichub/images/7/7b/Pentatonix.jpg',
							'width' => 330,
							'height' => 210,
						),
				]
			]
		];

		return $articles[ $wid ][ $aid ];
	}

	/**
	 * Mocked version of getArticleDescription without database calls. Used to test processItems
	 * @param $wid
	 * @param $aid
	 * @return string
	 */
	protected function getArticleDescription( $wid, $aid ) {
		$descriptions = [
			39778 => [
				2424 => 'Which 300 Character will prevail? '
			],
			8476 => [
				38393 => 'Have you ever looked at the giant block of carbonite Han Solo was frozen in and thought "that would look good in my living room?" Well now\'s your chance to make that happen!'
			],
			35171 => [
				485877 => 'Hold on because we are simultaneously squealing and crying over this teaser trailer for The Hunger Games: Mockingjay - Part 1! If you are confused why, check it out now below! The teaser is an address from President Snow, and kudos again to Donald Sutherland for doing such a great job in making us hate his character!'
			],
			37163 => [
				2737 => 'After thirty years after the last film, the Mad Max franchise is set to be reborn by none other than its creator, the legendary George Miller. This week\'s issue of Entertainment Weekly features an exclusive look at the upcoming film, and as a bonus, our first real look at Charlize Theron\'s character: Imperator Furiosa! '
			],
			411 => [
				56636 => 'Watch Wikia superfans battle it out. You could win!'
			],
			130814 => [
				26914 => 'Actors who play Grey Worm and Melisandre are talented singers.'
			],
			767908 => [
				2171 => 'BAND OF THE WEEK: 3rd Season "Sing Off" winners'
			]
		];

		return $descriptions[ $wid ][ $aid ];
	}

	/**
	 * Mocked version of fixDuplicatedTimestamps. Used to test processItems - separately from testing fixDuplicatedTimestamps
	 */
	protected function fixDuplicatedTimestamps( $items ) {
		if ( $this->testFixDuplicatedTimestamps ) {
			return parent::fixDuplicatedTimestamps( $items );
		}
		return $items;
	}
}

class DummyNotMockedModel extends BaseRssModel {
	const LANGUAGE = 'en';
	public function getFeedTitle() {
	}

	public function getFeedDescription() {
	}

	protected function loadData( $lastTimestamp, $duplicates ) {
	}

	protected function formatTitle( $item ) {
		return $item;
	}
}

/**
 * @group UsingDB
 */
class BaseRssModelTest extends WikiaBaseTest
{
	protected static function getFn($obj, $name)
	{
		$class = new ReflectionClass(get_class($obj));
		$method = $class->getMethod($name);
		$method->setAccessible(true);

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../../';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	/**
	 * @covers BaseRssModel::fixDuplicatedTimestamps
	 */
	public function testFixDuplicatedTimestamps() {
		$dummy = new DummyModel();
		$dummy->setTestFixDuplicatedTimestamps( true );
		$fixDuplicatedTimestamps = self::getFn( $dummy, 'fixDuplicatedTimestamps' );

		// Check with empty items map
		$itemsEmpty = [ ];
		$fixed = $fixDuplicatedTimestamps( $itemsEmpty );
		// Assert that all timestamps are unique
		$this->assertEquals(
			count( $itemsEmpty ),
			$this->countUniqueTimestamps( $fixed ) );

		// Check with items map, without timestamp duplicates
		$itemsWithoutDuplicatedTimestamps = [
			'1' => [ 'timestamp' => 1 ],
			'2' => [ 'timestamp' => 2 ],
			'3' => [ 'timestamp' => 3 ],
			'4' => [ 'timestamp' => 4 ]
		];
		$fixed = $fixDuplicatedTimestamps( $itemsWithoutDuplicatedTimestamps );
		// Assert that all timestamps are unique
		$this->assertEquals(
			count( $itemsWithoutDuplicatedTimestamps ),
			$this->countUniqueTimestamps( $fixed ) );

		// Check with items map, where timestamps duplicating
		$itemsWithDuplicatedTimestamps = [
			'1' => [ 'timestamp' => 1 ],
			'2' => [ 'timestamp' => 1 ],
			'3' => [ 'timestamp' => 2 ],
			'4' => [ 'timestamp' => 4 ],
			'5' => [ 'timestamp' => 4 ],
			'6' => [ 'timestamp' => 4 ],
			'7' => [ 'timestamp' => 5 ],
			'8' => [ 'timestamp' => 8 ]
		];
		$fixed = $fixDuplicatedTimestamps( $itemsWithDuplicatedTimestamps );
		// Assert that all timestamps are unique
		$this->assertEquals(
			count( $itemsWithDuplicatedTimestamps ),
			$this->countUniqueTimestamps( $fixed ) );
	}

	private function countUniqueTimestamps( &$itemsMap ) {
		$timestampsCount = [ ];
		foreach ( $itemsMap as $key => $value ) {
			$timestamp = $value[ BaseRssModel::FIELD_TIMESTAMP ];
			$timestampsCount[ $timestamp ] = 1;
		}
		return count( $timestampsCount );
	}

	/**
	 * @covers BaseRssModel::countUniqueTimestampsOccurrence
	 */
	public function testCountUniqueTimestampsOccurrence() {
		$dummy = new DummyModel();
		$countUniqueTimestampsOccurrence = self::getFn( $dummy, 'countUniqueTimestampsOccurrence' );

		// Check with empty items map
		$itemsEmpty = [ ];
		$actual = $countUniqueTimestampsOccurrence( $itemsEmpty );
		$expected = [ ];
		$this->assertEquals( $expected, $actual );

		// Check with items map, without timestamp duplicates
		$itemsWithoutDuplicatedTimestamps = [
			'1' => [ 'timestamp' => 1 ],
			'2' => [ 'timestamp' => 2 ],
			'3' => [ 'timestamp' => 3 ],
			'4' => [ 'timestamp' => 4 ]
		];
		$actual = $countUniqueTimestampsOccurrence( $itemsWithoutDuplicatedTimestamps );
		$expected = [
			1 => 1,
			2 => 1,
			3 => 1,
			4 => 1
		];
		$this->assertEquals( $expected, $actual );

		// Check with items map, where timestamps duplicating
		$itemsWithDuplicatedTimestamps = [
			'1' => [ 'timestamp' => 1 ],
			'2' => [ 'timestamp' => 1 ],
			'3' => [ 'timestamp' => 2 ],
			'4' => [ 'timestamp' => 4 ],
			'5' => [ 'timestamp' => 4 ],
			'6' => [ 'timestamp' => 4 ],
			'7' => [ 'timestamp' => 5 ],
			'8' => [ 'timestamp' => 8 ]
		];
		$actual = $countUniqueTimestampsOccurrence( $itemsWithDuplicatedTimestamps );
		$expected = [
			1 => 2,
			2 => 1,
			4 => 3,
			5 => 1,
			8 => 1
		];
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * @covers BaseRssModel::findAvailableTimestamp
	 */
	public function testFindAvailableTimestamp() {
		$dummy = new DummyModel();
		$findAvailableTimestamp = self::getFn( $dummy, 'findAvailableTimestamp' );

		$existingTimestamps = [
			1 => 1,
			2 => 1,
			3 => 1
		];

		for ( $i = 0; $i <= 10; $i++ ) {
			$timestamp = $findAvailableTimestamp( $i, $existingTimestamps );
			// Asserts that found timestamp is not exists in $existingTimestamps
			$this->assertTrue( empty( $existingTimestamps[ $timestamp ] ) );
		}
	}

	/**
	 * @covers BaseRssModel::makeBlogTitle
	 */
	public function testMakeBlogTitle() {
		$dummy = new DummyModel();
		$makeBlogTitle = self::getFn( $dummy, 'makeBlogTitle' );
		$item = [
			"ns" => NS_BLOG_ARTICLE,
			"wikititle" => "dummy",
			"page_id" => 4,
			"wikia_id" => 831,
		];

		$this->assertEquals( $makeBlogTitle( $item )[ 'title' ], "Muppet Wiki from dummy" );

		$item = [
			"ns" => NS_BLOG_ARTICLE,
			"page_id" => 4,
			"wikia_id" => 831,
		];
		$this->assertEquals( $makeBlogTitle( $item )[ 'title' ], "Muppet Wiki from Muppet Wiki" );
	}

	/**
	 * @covers BaseRssModel::removeDuplicates
	 */
	public function testRemoveDuplicates() {
		$dummy = new DummyModel();
		$removeDuplicates = self::getFn( $dummy, 'removeDuplicates' );

		$this->assertEquals( $removeDuplicates( null, null ), [ ] );

		$duplicatedRawData = [
			[ "url" => "a" ],
			[ "url" => "a" ],
			[ "url" => "b" ],
			[ "url" => "c" ],
		];
		$this->assertEquals( $removeDuplicates( $duplicatedRawData, null ), [
			[ "url" => "a" ],
			[ "url" => "a" ],
			[ "url" => "b" ],
			[ "url" => "c" ] ] );

		$this->assertEquals( array_values( $removeDuplicates( $duplicatedRawData, [ "a" => true, "c" => true ] ) ), [
			[ "url" => "b" ],
		] );

		$this->assertEquals( $removeDuplicates( $duplicatedRawData, [ "x" => true ] ), [
			[ "url" => "a" ],
			[ "url" => "a" ],
			[ "url" => "b" ],
			[ "url" => "c" ] ] );
	}

	/**
	 * @group UsingDB
	 * @covers BaseRssModel::processItems
	 */
	public function testProcessItems() {
		$dummy = new DummyModel();
		$dummy->setTestFixDuplicatedTimestamps( true );
		$processItems = self::getFn( $dummy, 'processItems' );

		$realData = $this->getRealData();

		$expectedProcessedData = $this->getExpectedProcessedRealData();

		$processedData = $processItems( $realData );

		// Assert that all timestamps are unique
		$this->assertEquals(
			count( $processedData ),
			$this->countUniqueTimestamps( $processedData ) );

		// Asserts that number of elements in $processedData is the same as in $expectedProcessedData
		$this->assertEquals( count( $expectedProcessedData ), count( $processedData ) );

		foreach ( $expectedProcessedData as $key => $expectedValue ) {
			// Asserts that all expected keys are present in $processedData
			$this->assertNotEmpty( $processedData[ $key ] );

			// Assert equality of expected and actual elements, which corresponding to $key
			$actualValue = $processedData[ $key ];
			$this->assertEquals( $expectedValue, $actualValue );
		}
	}

	/**
	 * @covers BaseRssModel::getArticleDetail
	 */
	public function testGetArticleDetailThumbExists() {
		$this->mockStaticMethod( 'ApiService', 'foreignCall',
			[
				'items' => [
					222 => [
						'thumbnail' => 'tt',
						'original_dimensions' => [ 'width' => 11, 'height' => 333 ],
						'title' => 'xxx'
					]
				]
			]
		);

		$this->mockStaticMethod( 'ImagesService', 'getFileUrlFromThumbUrl', 'asdfg' );

		$mock = $this->getMockBuilder( 'BaseRssModel' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getFeedTitle', 'getFeedLanguage', 'getFeedDescription', 'loadData', 'formatTitle' ] )
			->getMock();

		$function = self::getFn( $mock, 'getArticleDetail' );

		$expected = [ 'img' => [ 'url' => "asdfg", 'width' => 200, 'height' => 333 ], 'title' => "xxx" ];

		$this->assertEquals( $expected, $function( 99, 222 ) );

	}

	/**
	 * @covers BaseRssModel::getArticleDetail
	 */
	public function testGetArticleDetailWordmark() {
		$this->mockStaticMethod( 'ApiService', 'foreignCall',
			[
				'items' => [
					222 => [
						'thumbnail' => null,
						'original_dimensions' => [ 'width' => null, 'height' => null ],
						'title' => 'xxx'
					]
				]
			]
		);

		$mockWs = $this->getMockBuilder( 'WikiService' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getWikiWordmark' ] )
			->getMock();

		$mockWs->expects( $this->any() )
			->method( 'getWikiWordmark' )
			->with( 99 )
			->will( $this->returnValue( 'wordmark11.png' ) );

		$mock = $this->getMockBuilder( 'BaseRssModel' )
			->disableOriginalConstructor()
			->setMethods( [
				'__construct', 'getFeedTitle', 'getFeedLanguage',
				'getFeedDescription', 'loadData', 'formatTitle', 'getWikiService'
			] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getWikiService' )
			->will( $this->returnValue( $mockWs ) );

		$function = self::getFn( $mock, 'getArticleDetail' );

		$expected = [ 'img' => [ 'url' => "wordmark11.png", 'width' => 200, 'height' => 200 ], 'title' => "xxx" ];

		$this->assertEquals( $expected, $function( 99, 222 ) );
	}

	/**
	 * @covers BaseRssModel::getArticleDescription
	 */
	public function testGetArticleDescription() {
		$this->mockStaticMethod( 'WikiFactory', 'IDtoDB', null );
		$this->mockStaticMethod( 'ApiService', 'foreignCall',
			[
				'sections' => [
					[ 'content' => 'section_1' ],
					[ 'content' => [
						[ 'type' => 'cc' ],
						[ 'type' => 'paragraph', 'text' => 'test1' ]
					]
					]
				]
			]
		);

		$mock = $this->getMockBuilder( 'BaseRssModel' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getFeedTitle', 'getFeedLanguage', 'getFeedDescription', 'loadData', 'formatTitle' ] )
			->getMock();
		$function = self::getFn( $mock, 'getArticleDescription' );
		$this->assertEquals( 'test1', $function( 11, 22 ) );
	}

	protected function getRealData() {
		$items = [
			0 =>
				array (
					'module' => 'slider',
					'timestamp' => '1403395200',
					'url' => 'http://300.wikia.com/wiki/300:_RISE_OF_AN_EMPIRE_BATTLE',
					'wikia_id' => 39778,
					'page_id' => 2424,
					'source' => 'hub_952442',
				),
			1 =>
				array (
					'module' => 'community',
					'timestamp' => '1403136000',
					'url' => 'http://starwarsfans.wikia.com/wiki/User_blog:Brandon_Rhea/Sideshow_Collectibles_is_Giving_Away_a_Life-Sized_Han_Solo_in_Carbonite',
					'wikia_id' => 8476,
					'page_id' => 38393,
					'source' => 'hub_952442',
				),
			2 =>
				array (
					'module' => 'community',
					'timestamp' => '1403654400',
					'url' => 'http://thehungergames.wikia.com/wiki/User_blog:Gcheung28/Mockingjay_Part_1_Teaser_Trailer_Released',
					'wikia_id' => 35171,
					'page_id' => 485877,
					'source' => 'hub_952442',
				),
			3 =>
				array (
					'module' => 'community',
					'timestamp' => '1403654400',
					'url' => 'http://madmax.wikia.com/wiki/User_blog:XD1/Hardy_%26Theron_MAD_MAX_Ent.Weekly_Cover',
					'wikia_id' => 37163,
					'page_id' => 2737,
					'source' => 'hub_952442',
				),
			4 =>
				array (
					'module' => 'slider',
					'timestamp' => '1403654400',
					'url' => 'http://transformers.wikia.com/wiki/User_blog:Gcheung28/Wikia_Qwizards:_Transformers',
					'wikia_id' => 411,
					'page_id' => 56636,
					'source' => 'hub_952442',
				),
			5 =>
				array (
					'module' => 'slider',
					'timestamp' => '1403654400',
					'url' => 'http://300.wikia.com/wiki/300:_RISE_OF_AN_EMPIRE_BATTLE',
					'wikia_id' => 39778,
					'page_id' => 2424,
					'source' => 'hub_952445',
				),
			6 =>
				array (
					'module' => 'community',
					'timestamp' => '1403136000',
					'url' => 'http://starwarsfans.wikia.com/wiki/User_blog:Brandon_Rhea/Sideshow_Collectibles_is_Giving_Away_a_Life-Sized_Han_Solo_in_Carbonite',
					'wikia_id' => 8476,
					'page_id' => 38393,
					'source' => 'hub_952445',
				),
			7 =>
				array (
					'module' => 'slider',
					'timestamp' => '1403654400',
					'url' => 'http://transformers.wikia.com/wiki/User_blog:Gcheung28/Wikia_Qwizards:_Transformers',
					'wikia_id' => 411,
					'page_id' => 56636,
					'source' => 'hub_952445',
				),
			8 =>
				array (
					'module' => 'community',
					'timestamp' => '1403568000',
					'url' => 'http://gameofthrones.wikia.com/wiki/User_blog:Gcheung28/Game_of_Thrones_Musical_Talents',
					'wikia_id' => 130814,
					'page_id' => 26914,
					'source' => 'hub_952443',
				),
			9 =>
				array (
					'module' => 'slider',
					'timestamp' => '1403654400',
					'url' => 'http://pentatonix.wikia.com/wiki/User_blog:Alwaysmore2hear/Pentatonix_set_to_appear_in_%27Pitch_Perfect_2%27',
					'wikia_id' => 767908,
					'page_id' => 2171,
					'source' => 'hub_952443',
				)
		];
		return $items;
	}

	protected function getExpectedProcessedRealData() {
		$processedData =
			array (
				'http://300.wikia.com/wiki/300:_RISE_OF_AN_EMPIRE_BATTLE' =>
					array (
						'module' => 'slider',
						'description' => 'Which 300 Character will prevail? ',
						'title' => '300 BATTLE',
						'img' =>
							array (
								'url' => 'http://img2.wikia.nocookie.net/__cb20140625165411/comicshub/images/e/e0/300RoeE_VERS_medrec_330x210.jpg',
								'width' => 330,
								'height' => 210,
							),
						'timestamp' => 1403654401,
						'url' => 'http://300.wikia.com/wiki/300:_RISE_OF_AN_EMPIRE_BATTLE',
						'wikia_id' => 39778,
						'page_id' => 2424,
						'source' => 'hub_952445',
					),
				'http://starwarsfans.wikia.com/wiki/User_blog:Brandon_Rhea/Sideshow_Collectibles_is_Giving_Away_a_Life-Sized_Han_Solo_in_Carbonite' =>
					array (
						'title' => 'Win a Life-Sized Han Solo in Carbonite',
						'description' => 'Have you ever looked at the giant block of carbonite Han Solo was frozen in and thought "that would look good in my living room?" Well now\'s your chance to make that happen!',
						'module' => 'community',
						'img' =>
							array (
								'url' => 'http://img3.wikia.nocookie.net/__cb20140619233829/comicshub/images/d/dd/HanSoloCarbonite.jpg',
								'width' => 454,
								'height' => 363,
							),
						'timestamp' => '1403136000',
						'url' => 'http://starwarsfans.wikia.com/wiki/User_blog:Brandon_Rhea/Sideshow_Collectibles_is_Giving_Away_a_Life-Sized_Han_Solo_in_Carbonite',
						'wikia_id' => 8476,
						'page_id' => 38393,
						'source' => 'hub_952445',
					),
				'http://thehungergames.wikia.com/wiki/User_blog:Gcheung28/Mockingjay_Part_1_Teaser_Trailer_Released' =>
					array (
						'title' => 'Mockingjay Part 1 Teaser Trailer Released',
						'description' => 'Hold on because we are simultaneously squealing and crying over this teaser trailer for The Hunger Games: Mockingjay - Part 1! If you are confused why, check it out now below! The teaser is an address from President Snow, and kudos again to Donald Sutherland for doing such a great job in making us hate his character!',
						'module' => 'community',
						'img' =>
							array (
								'url' => 'http://img3.wikia.nocookie.net/__cb20140625182417/movieshub/images/d/da/Movieshub-Mockingjay-Trailer_01.jpg',
								'width' => 300,
								'height' => 258,
							),
						'timestamp' => 1403654402,
						'url' => 'http://thehungergames.wikia.com/wiki/User_blog:Gcheung28/Mockingjay_Part_1_Teaser_Trailer_Released',
						'wikia_id' => 35171,
						'page_id' => 485877,
						'source' => 'hub_952442',
					),
				'http://madmax.wikia.com/wiki/User_blog:XD1/Hardy_%26Theron_MAD_MAX_Ent.Weekly_Cover' =>
					array (
						'title' => 'Mad Max: Fury Road - First Look: Charlize Theron as Furiosa!',
						'description' => 'After thirty years after the last film, the Mad Max franchise is set to be reborn by none other than its creator, the legendary George Miller. This week\'s issue of Entertainment Weekly features an exclusive look at the upcoming film, and as a bonus, our first real look at Charlize Theron\'s character: Imperator Furiosa! ',
						'module' => 'community',
						'img' =>
							array (
								'url' => 'http://img3.wikia.nocookie.net/__cb20140625212526/movieshub/images/8/84/Movieshub-MADMAX_Furiosa.jpg',
								'width' => 350,
								'height' => 233,
							),
						'timestamp' => 1403654403,
						'url' => 'http://madmax.wikia.com/wiki/User_blog:XD1/Hardy_%26Theron_MAD_MAX_Ent.Weekly_Cover',
						'wikia_id' => 37163,
						'page_id' => 2737,
						'source' => 'hub_952442',
					),
				'http://transformers.wikia.com/wiki/User_blog:Gcheung28/Wikia_Qwizards:_Transformers' =>
					array (
						'title' => 'Transformers Qwizards',
						'description' => 'Watch Wikia superfans battle it out. You could win!',
						'module' => 'slider',
						'img' =>
							array (
								'url' => 'http://img1.wikia.nocookie.net/__cb20140626012112/comicshub/images/7/7e/QWIZ14_TRANS_Hubslider_330x210.jpg',
								'width' => 330,
								'height' => 210,
							),
						'timestamp' => 1403654404,
						'url' => 'http://transformers.wikia.com/wiki/User_blog:Gcheung28/Wikia_Qwizards:_Transformers',
						'wikia_id' => 411,
						'page_id' => 56636,
						'source' => 'hub_952445',
					),
				'http://gameofthrones.wikia.com/wiki/User_blog:Gcheung28/Game_of_Thrones_Musical_Talents' =>
					array (
						'title' => 'GAME OF THRONES Musical Talents',
						'description' => 'Actors who play Grey Worm and Melisandre are talented singers.',
						'module' => 'community',
						'img' =>
							array (
								'url' => 'http://img2.wikia.nocookie.net/__cb20140624211238/musichub/images/d/d3/Screen_Shot_2014-06-24_at_2.11.59_PM.png',
								'width' => 486,
								'height' => 267,
							),
						'timestamp' => '1403568000',
						'url' => 'http://gameofthrones.wikia.com/wiki/User_blog:Gcheung28/Game_of_Thrones_Musical_Talents',
						'wikia_id' => 130814,
						'page_id' => 26914,
						'source' => 'hub_952443',
					),
				'http://pentatonix.wikia.com/wiki/User_blog:Alwaysmore2hear/Pentatonix_set_to_appear_in_%27Pitch_Perfect_2%27' =>
					array (
						'title' => 'PENTATONIX',
						'description' => 'BAND OF THE WEEK: 3rd Season "Sing Off" winners',
						'module' => 'slider',
						'img' =>
							array (
								'url' => 'http://img4.wikia.nocookie.net/__cb20140625184430/musichub/images/7/7b/Pentatonix.jpg',
								'width' => 330,
								'height' => 210,
							),
						'timestamp' => '1403654400',
						'url' => 'http://pentatonix.wikia.com/wiki/User_blog:Alwaysmore2hear/Pentatonix_set_to_appear_in_%27Pitch_Perfect_2%27',
						'wikia_id' => 767908,
						'page_id' => 2171,
						'source' => 'hub_952443',
					),
			);
		return $processedData;
	}

}
