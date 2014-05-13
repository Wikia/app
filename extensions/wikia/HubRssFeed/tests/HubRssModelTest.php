<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */

class HubRssModelTest extends WikiaBaseTest {

	/**
	 * @var PHPUnit_Framework_MockObject_MockBuilder
	 */
	protected $mockToolbox;

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		global $wgAutoloadClasses;
		$wgAutoloadClasses['WikiaHubsModuleSliderService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleSliderService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleFromthecommunityService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleFromthecommunityService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleWikiaspicksService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleWikiaspicksService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleEditableService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleEditableService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleFeaturedvideoService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleFeaturedvideoService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleExploreService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleExploreService.class.php';
		$wgAutoloadClasses['WikiaHubsModulePollsService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModulePollsService.class.php';
		$wgAutoloadClasses['WikiaHubsModulePopularvideosService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModulePopularvideosService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleWAMService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleWAMService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleNonEditableService'] = $dir . '../WikiaHubsServices/modules/WikiaHubsModuleNonEditableService.class.php';
		$wgAutoloadClasses['WikiaHubsModuleService'] =  $dir . '../WikiaHubsServices/modules/WikiaHubsModuleService.class.php';
		$wgAutoloadClasses['EditHubModel']	= $dir . '../WikiaHubsServices/models/EditHubModel.class.php';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';
		$this->mockToolbox = $this->getMockBuilder( 'EditHubModel' )
			->disableOriginalConstructor();

		parent::setUp();
	}


	/**
	 * @covers  HubRssFeedModel::__construct
	 */
	public function testConstruct() {
		$mockToolbox = $this->mockToolbox->setMethods( ['__construct'] )->getMock();

		$this->mockClass( 'EditHubModel', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->setConstructorArgs( ['en'] )
			->setMethods( ['setUpModel'] )
			->getMock();

		$refl = new \ReflectionObject($mock);

		$propApp = $refl->getProperty( 'app' );
		$propApp->setAccessible( true );

		$propToolbox = $refl->getProperty( 'editHubModel' );
		$propToolbox->setAccessible( true );

		//checking for $this->app inside controller
		$this->assertInstanceOf( 'WikiaApp', $propApp->getValue( $mock ) );
		$this->assertInstanceOf( get_class( $mockToolbox ), $propToolbox->getValue( $mock ) );


	}

	/**
	 * @covers  HubRssFeedModel::getServicesV3
	 */
	public function testGetServicesV3() {
		$mockSlider = $this->getMockBuilder( 'WikiaHubsModuleSliderService' )
			->setMethods( ['__construct'] )
			->disableOriginalConstructor()
			->getMock();

		$mockCommunity = $this->getMockBuilder( 'WikiaHubsModuleFromthecommunityService' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$this->mockClass( 'WikiaHubsModuleSliderService', $mockSlider );
		$this->mockClass( 'WikiaHubsModuleFromthecommunityService', $mockCommunity );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$methodServices = $refl->getMethod( 'getServicesV3' );
		$methodServices->setAccessible( true );

		$res = $methodServices->invoke( $mock, [null] );
		$this->assertInstanceOf( get_class( $mockSlider ), $res[ 'slider' ] );
		$this->assertInstanceOf( get_class( $mockCommunity ), $res[ 'community' ] );

	}
	
	public function testGetFirstValue() {
		$data = ["k1" => 1, "k2" => 2];
		$this->assertEquals(1, HubRssFeedModel::getFirstValue($data, ["nothing", "k1", "k2", "another nothing"]));
		$this->assertEquals(2, HubRssFeedModel::getFirstValue($data, ["nothing", "k2", "k1", "another nothing"]));		
	}




	/**
	 * @covers  HubRssFeedModel::getDataFromModulesV3
	 */
	public function testGetDataFromModulesV3() {
		$mockSlider = $this->getMockBuilder( 'WikiaHubsModuleSliderService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockCommunity = $this->getMockBuilder( 'WikiaHubsModuleFromthecommunityService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockWikiaspicks = $this->getMockBuilder( 'WikiaHubsModuleWikiaspicksService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockSlider->expects( $this->any() )
			->method( 'loadData' )
			->will( $this->returnValue( ['a' => [['shortDesc' => 'a1', 'longDesc' => 'a2', 'photoName' => 'a3', 'articleUrl' => 'a4']]] ) );

		$mockCommunity->expects( $this->any() )
			->method( 'loadData' )
			->will( $this->returnValue( ['a' => [['articleTitle' => 'b1', 'quote' => 'b2', 'photoName' => 'b3', 'url' => 'b4']]] ) );

		$mockWikiaspicks->expects( $this->any() )
			->method( 'loadData' )
			->will( $this->returnValue( ['a' => [["title" => "c1", "text" => "c2", "imageAlt" => 'c3', "imageLink" => "c4"]]] ) );


		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['getServicesV3', 'getThumbData'] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getServicesV3' )
			->will( $this->returnValue( ['slider' => $mockSlider, 'community' => $mockCommunity,
					'wikiaspicks' => $mockWikiaspicks] ) );

		$tmp = new StdClass();
		$tmp->url = 'xx';
		$tmp->width = 500;
		$tmp->height = 500;
		$mock->expects( $this->any() )
			->method( 'getThumbData' )
			->will( $this->returnValue( $tmp ) );


		$refl = new \ReflectionObject($mock);
		$methodGDFM = $refl->getMethod( 'getDataFromModulesV3' );
		$methodGDFM->setAccessible( true );

		$res = $methodGDFM->invoke( $mock, [null] );

		$this->assertArrayHasKey( 'a4', $res );
		$this->assertEquals( 'a1', $res[ 'a4' ][ 'title' ] );
		$this->assertEquals( 'a2', $res[ 'a4' ][ 'description' ] );
		$this->assertArrayHasKey( 'img', $res[ 'a4' ] );
		$this->assertEquals( 'xx', $res[ 'a4' ][ 'img' ][ 'url' ]  );
		$this->assertEquals( 500, $res[ 'a4' ][ 'img' ][ 'width' ] );
		$this->assertEquals( 500, $res[ 'a4' ][ 'img' ][ 'height' ] );

		$this->assertArrayHasKey( 'b4', $res );
		$this->assertEquals( 'b1', $res[ 'b4' ][ 'title' ] );
		$this->assertEquals( 'b2', $res[ 'b4' ][ 'description' ] );
		$this->assertArrayHasKey( 'img', $res[ 'b4' ] );
		$this->assertEquals( 'xx', $res[ 'b4' ][ 'img' ][ 'url' ]);
		$this->assertEquals( 500, $res[ 'b4' ][ 'img' ][ 'width' ] );
		$this->assertEquals( 500, $res[ 'b4' ][ 'img' ][ 'height' ] );

		$this->assertArrayHasKey( 'c4', $res );
		$this->assertEquals( 'c1' , $res[ 'c4' ][ 'title' ] );
		$this->assertEquals( 'c2', $res[ 'c4' ][ 'description' ] );
		$this->assertArrayHasKey( 'img', $res[ 'c4' ] );
		$this->assertEquals( 'xx', $res[ 'b4' ][ 'img' ][ 'url' ] );
		$this->assertEquals( 500, $res[ 'b4' ][ 'img' ][ 'width' ] );
		$this->assertEquals( 500, $res[ 'b4' ][ 'img' ][ 'height' ] );
	}

	/**
	 * @covers  HubRssFeedModel::getRealDataV3
	 */
	public function testGetRealDataV3() {
		$mockToolbox = $this->mockToolbox->setMethods( ['getLastPublishedTimestamp'] )->getMock();

		$mockToolbox->expects( $this->any() )
			->method( 'getLastPublishedTimestamp', '__construct' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getLastPublishedTimestamp' ) );

		$this->mockClass( 'EditHubModel', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['getDataFromModulesV3'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty( 'editHubModel' );
		$prop->setAccessible( true );
		$prop->setValue( $mock, $mockToolbox );

		$mock->expects( $this->any() )
			->method( 'getDataFromModulesV3' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getDataFromModulesV3' ) );

		$res = $mock->getRealDataV3( 1 ); // non-zero number

		$this->assertArrayHasKey( 'url_1', $res );
		$this->assertEquals( HubRssFeedModel::MIN_DATE_FOUND, $res[ 'url_1' ][ 'timestamp' ] );

		$this->assertArrayHasKey( 'url_2', $res );
		$this->assertEquals( 1001, $res[ 'url_2' ][ 'timestamp' ] );

		$this->assertArrayNotHasKey( 'url_3', $res );

		$this->assertArrayHasKey( 'url_4', $res );
		$this->assertEquals( 991, $res[ 'url_4' ][ 'timestamp' ] );

		$item1 = array_shift( $res );
		$item2 = array_shift( $res );
		$item3 = array_shift( $res );

		$this->assertTrue( $item1[ 'timestamp' ] >= $item2[ 'timestamp' ] && $item2[ 'timestamp' ] >= $item3[ 'timestamp' ] );

	}

	public static function mock_getDataFromModulesV3( $cityId, $timestamp = null ) {
		$timestamp = (int)$timestamp;

		$lastEntry = 1001 - (HubRssFeedModel::MAX_DATE_LOOP * 10);

		$arr = [
			0 => [
				'url_1' => ['title' => 'a1', 'description' => 'a2', 'img' => 'a3'],
				'url_2' => ['title' => 'b1', 'description' => 'b2', 'img' => 'b3'],
				'url_4' => ['title' => 'b1', 'description' => 'b2', 'img' => 'b3']
			],

			991 => [
				'url_1' => ['title' => 'a1', 'description' => 'a2', 'img' => 'a3'],
				'url_4' => ['title' => 'b1', 'description' => 'b2', 'img' => 'b3']],

			981 => [
				'url_1' => ['title' => 'a1', 'description' => 'a2', 'img' => 'a3'],
				'url_3' => ['title' => 'c1', 'description' => 'c2', 'img' => 'c3']
			],

			$lastEntry => [
				'url_1' => ['title' => 'a1', 'description' => 'a2', 'img' => 'a3'],
			]
		];

		if ( !array_key_exists( $timestamp, $arr ) ) {
			return null;
		}

		return $arr[ $timestamp ];
	}


	public static function mock_getLastPublishedTimestamp( $params, $timestamp ) {
		if ( $timestamp === null ) {
			$timestamp = 1001;
		}
		else {
			$timestamp -= 9;
		}
		return $timestamp;

	}

}
