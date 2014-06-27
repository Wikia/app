<?php
include_once dirname(__FILE__) . '/../../' . "models/BaseRssModel.class.php";

class DummyModel extends BaseRssModel
{
	public function getFeedTitle()
	{
	}

	public function getFeedLanguage()
	{
	}

	public function getFeedDescription()
	{
	}

	protected function loadData($lastTimestamp, $duplicates)
	{
	}

	protected function formatTitle($item)
	{
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
			831 => [
				49 => [ 'img' => [ 'url' => 'uaa', 'width' => 11, 'height' => 22 ], 'title' => 'taa' ],
				4 => [ 'img' => [ 'url' => 'ubb', 'width' => 33, 'height' => 44 ], 'title' => 'tbb' ]
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
	protected function getArticleDescription( $wid, $aid ){
		$descriptions = [
			831 => [
				49 => 'd49',
				4 => 'd4'
			]
		];

		return $descriptions[ $wid ][ $aid ];
	}
}

class DummyNotMockedModel extends BaseRssModel {
	public function getFeedTitle()
	{
	}

	public function getFeedLanguage()
	{
	}

	public function getFeedDescription()
	{
	}

	protected function loadData($lastTimestamp, $duplicates)
	{
	}

	protected function formatTitle($item)
	{
		return $item;
	}
}

class BaseRssModelTest extends WikiaBaseTest
{
	protected static function getFn( $obj, $name )
	{
		$class = new ReflectionClass(get_class($obj));
		$method = $class->getMethod($name);
		$method->setAccessible(true);

        return function () use ( $obj, $method ) {
            $args = func_get_args();
            return $method->invokeArgs($obj, $args);
        };
	}

	public function setUp()
	{
		$dir = dirname(__FILE__) . '/../../';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

    /**
     * @covers BaseRssModel::fixDuplicatedTimestamps
     */
    public function testFixDuplicatedTimestamps()
    {
        $dummy = new DummyModel();
        $fixDuplicatedTimestamps = self::getFn( $dummy, 'fixDuplicatedTimestamps' );

        // Check with empty items map
        $empty = [ ];
        $fixed = $fixDuplicatedTimestamps( $empty );
        $this->assertEquals(
            count( $empty ),
            $this->countUniqueTimestamps( $fixed ) );

        // Check with items map, without timestamps duplicates
        $noDuplicatedTimestamps = [
            '1' => [ 'timestamp' => 1 ],
            '2' => [ 'timestamp' => 2 ],
            '3' => [ 'timestamp' => 3 ],
            '4' => [ 'timestamp' => 4 ]
        ];
        $fixed = $fixDuplicatedTimestamps( $noDuplicatedTimestamps );
        $this->assertEquals(
            count( $noDuplicatedTimestamps ),
            $this->countUniqueTimestamps( $fixed ) );

        // Check with items map, with timestamps duplicates
        $duplicatedTimestamps = [
            '1' => [ 'timestamp' => 1 ],
            '2' => [ 'timestamp' => 1 ],
            '3' => [ 'timestamp' => 2 ],
            '4' => [ 'timestamp' => 4 ],
            '5' => [ 'timestamp' => 4 ],
            '6' => [ 'timestamp' => 4 ],
            '7' => [ 'timestamp' => 5 ],
            '8' => [ 'timestamp' => 8 ]
        ];
        $fixed = $fixDuplicatedTimestamps( $duplicatedTimestamps );
        $this->assertEquals(
            count( $duplicatedTimestamps ),
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
	 * @covers BaseRssModel::makeBlogTitle
	 */
	public function testMakeBlogTitle()
	{
		$dummy = new DummyModel();
		$makeBlogTitle = self::getFn($dummy, 'makeBlogTitle');
		$item = [
			"ns" => NS_BLOG_ARTICLE,
			"wikititle" => "dummy",
			"page_id" => 4,
			"wikia_id" => 831,
		];

		$this->assertEquals($makeBlogTitle($item)['title'], "Muppet Wiki from dummy");

		$item = [
			"ns" => NS_BLOG_ARTICLE,
			"page_id" => 4,
			"wikia_id" => 831,
		];
		$this->assertEquals($makeBlogTitle($item)['title'], "Muppet Wiki from Muppet Wiki");
	}

	/**
	 * @covers BaseRssModel::removeDuplicates
	 */
	public function testRemoveDuplicates()
	{
		$dummy = new DummyModel();
		$removeDuplicates = self::getFn($dummy, 'removeDuplicates');

		$this->assertEquals($removeDuplicates(null, null), []);

		$duplicatedRawData = [
			["url" => "a"],
			["url" => "a"],
			["url" => "b"],
			["url" => "c"],
		];
		$this->assertEquals($removeDuplicates($duplicatedRawData, null), [
			["url" => "a"],
			["url" => "a"],
			["url" => "b"],
			["url" => "c"]]);

		$this->assertEquals(array_values($removeDuplicates($duplicatedRawData, ["a" => true, "c" => true])), [
			["url" => "b"],
		]);

		$this->assertEquals($removeDuplicates($duplicatedRawData, ["x" => true]), [
			["url" => "a"],
			["url" => "a"],
			["url" => "b"],
			["url" => "c"]]);
	}

	/**
	 * @group UsingDB
	 * @covers BaseRssModel::processItems
	 */
	public function testProcessItems()
	{
		$dummy = new DummyModel();
		$processItems = self::getFn($dummy, 'processItems');

		$sampleItems = [
			[
				'url' => "dummy_url",
				"ns" => NS_BLOG_ARTICLE,
				"page_id" => 49, //miss piggy
				"wikia_id" => 831, //muppets
			],
			[
				'url' => "dummy_url2",
				"ns" => NS_BLOG_ARTICLE,
				"page_id" => 4,
				"wikia_id" => 831,
			],
		];

		$processedData = $processItems($sampleItems);
		$this->assertArrayHasKey('timestamp', $processedData['dummy_url']);
		$this->assertLessThan($processedData['dummy_url']['timestamp'], $processedData['dummy_url2']['timestamp']);

		$this->assertEquals( 'd49', $processedData[ 'dummy_url' ][ 'description' ] );
		$this->assertEquals( 'uaa', $processedData[ 'dummy_url' ][ 'img' ][ 'url' ] );
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
						'original_dimensions' => [ 'width' => null, 'height' => null  ],
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
				'getFeedDescription', 'loadData', 'formatTitle','getWikiService'
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

}
