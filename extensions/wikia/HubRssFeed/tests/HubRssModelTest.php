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
		$wgAutoloadClasses['MarketingToolboxModel']	= $dir . '../WikiaHubsServices/models/MarketingToolboxModel.class.php';
		$wgAutoloadClasses['AbstractMarketingToolboxModel']	= $dir . '../WikiaHubsServices/models/AbstractMarketingToolboxModel.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleSliderService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleSliderService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleFromthecommunityService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleFromthecommunityService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleWikiaspicksService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleWikiaspicksService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleEditableService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleEditableService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleFeaturedvideoService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleFeaturedvideoService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleExploreService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleExploreService.class.php';
		$wgAutoloadClasses['MarketingToolboxModulePollsService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModulePollsService.class.php';
		$wgAutoloadClasses['MarketingToolboxModulePopularvideosService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModulePopularvideosService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleWAMService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleWAMService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleNonEditableService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleNonEditableService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleService'] =  $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleService.class.php';
		$wgAutoloadClasses['MarketingToolboxV3Model']	= $dir . '../WikiaHubsServices/models/MarketingToolboxV3Model.class.php';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';
		$this->mockToolbox = $this->getMockBuilder( 'MarketingToolboxModel' )
			->disableOriginalConstructor();

		parent::setUp();
	}


	/**
	 * @covers  HubRssFeedModel::__construct
	 */
	public function testConstruct() {
		$mockToolbox = $this->mockToolbox->setMethods( ['__construct'] )->getMock();

		$this->mockClass( 'MarketingToolboxV2Model', $mockToolbox );
		$this->mockClass( 'MarketingToolboxV3Model', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->setConstructorArgs( ['en'] )
			->setMethods( ['setUpModel'] )
			->getMock();

		$refl = new \ReflectionObject($mock);

		$propApp = $refl->getProperty( 'app' );
		$propApp->setAccessible( true );

		$propToolbox = $refl->getProperty( 'marketingToolboxV2Model' );
		$propToolbox->setAccessible( true );

		$propToolbox = $refl->getProperty( 'marketingToolboxV3Model' );
		$propToolbox->setAccessible( true );

		//checking for $this->app inside controller
		$this->assertInstanceOf( 'WikiaApp', $propApp->getValue( $mock ) );
		$this->assertInstanceOf( get_class( $mockToolbox ), $propToolbox->getValue( $mock ) );


	}

	/**
	 * @covers  HubRssFeedModel::getServicesV2
	 */
	public function testGetServicesV2() {
		$mockSlider = $this->getMockBuilder( 'MarketingToolboxModuleSliderService' )
			->setMethods( ['__construct'] )
			->disableOriginalConstructor()
			->getMock();

		$mockCommunity = $this->getMockBuilder( 'MarketingToolboxModuleFromthecommunityService' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$this->mockClass( 'MarketingToolboxModuleSliderService', $mockSlider );
		$this->mockClass( 'MarketingToolboxModuleFromthecommunityService', $mockCommunity );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$methodServices = $refl->getMethod( 'getServicesV2' );
		$methodServices->setAccessible( true );

		$res = $methodServices->invoke( $mock, [null] );
		$this->assertInstanceOf( get_class( $mockSlider ), $res[ 'slider' ] );
		$this->assertInstanceOf( get_class( $mockCommunity ), $res[ 'community' ] );

	}

	/**
	 * @covers  HubRssFeedModel::getServicesV3
	 */
	public function testGetServicesV3() {
		$mockSlider = $this->getMockBuilder( 'MarketingToolboxModuleSliderService' )
			->setMethods( ['__construct'] )
			->disableOriginalConstructor()
			->getMock();

		$mockCommunity = $this->getMockBuilder( 'MarketingToolboxModuleFromthecommunityService' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$this->mockClass( 'MarketingToolboxModuleSliderService', $mockSlider );
		$this->mockClass( 'MarketingToolboxModuleFromthecommunityService', $mockCommunity );

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
	 * @covers  HubRssFeedModel::getDataFromModulesV2
	 */
	public function testGetDataFromModulesV2() {
		$mockSlider = $this->getMockBuilder( 'MarketingToolboxModuleSliderService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockCommunity = $this->getMockBuilder( 'MarketingToolboxModuleFromthecommunityService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockWikiaspicks = $this->getMockBuilder( 'MarketingToolboxModuleWikiaspicksService' )
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
			->setMethods( ['getServicesV2', 'getThumbData'] )
			->getMock();
		
		$mock->expects( $this->any() )
			->method( 'getServicesV2' )
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
		$methodGDFM = $refl->getMethod( 'getDataFromModulesV2' );
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
	 * @covers  HubRssFeedModel::getDataFromModulesV3
	 */
	public function testGetDataFromModulesV3() {
		$mockSlider = $this->getMockBuilder( 'MarketingToolboxModuleSliderService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockCommunity = $this->getMockBuilder( 'MarketingToolboxModuleFromthecommunityService' )
			->disableOriginalConstructor()
			->setMethods( ['loadData'] )
			->getMock();

		$mockWikiaspicks = $this->getMockBuilder( 'MarketingToolboxModuleWikiaspicksService' )
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
			->will( $this->returnValue( ['a' => [["moduleTitle" => "c1", "description" => "c2", "fileName" => 'c3', "imageLink" => "c4"]]] ) );


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
	 * @covers  HubRssFeedModel::getRealDataV2
	 */
	public function testGetRealDataV2() {
		$mockToolbox = $this->mockToolbox->setMethods( ['getLastPublishedTimestamp'] )->getMock();

		$mockToolbox->expects( $this->any() )
			->method( 'getLastPublishedTimestamp', '__construct' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getLastPublishedTimestamp' ) );

		$this->mockClass( 'MarketingToolboxV2Model', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['getDataFromModulesV2'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty( 'marketingToolboxV2Model' );
		$prop->setAccessible( true );
		$prop->setValue( $mock, $mockToolbox );

		$mock->expects( $this->any() )
			->method( 'getDataFromModulesV2' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getDataFromModulesV2' ) );

		$res = $mock->getRealDataV2( 1 ); // non-zero number

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

	/**
	 * @covers  HubRssFeedModel::getRealDataV3
	 */
	public function testGetRealDataV3() {
		$mockToolbox = $this->mockToolbox->setMethods( ['getLastPublishedTimestamp'] )->getMock();

		$mockToolbox->expects( $this->any() )
			->method( 'getLastPublishedTimestamp', '__construct' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getLastPublishedTimestamp' ) );

		$this->mockClass( 'MarketingToolboxV3Model', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['getDataFromModulesV3'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty( 'marketingToolboxV3Model' );
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

	public static function mock_getDataFromModulesV2( $verticalid, $timestamp = null ) {
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
