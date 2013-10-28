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
		require_once $dir . '../WikiaHubsServices/models/MarketingToolboxModel.class.php';
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

		$this->mockClass( 'MarketingToolboxModel', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->setConstructorArgs( ['en'] )
			->setMethods( ['setUpModel'] )
			->getMock();


		$refl = new \ReflectionObject($mock);

		$propApp = $refl->getProperty( 'app' );
		$propApp->setAccessible( true );

		$propToolbox = $refl->getProperty( 'marketingToolboxModel' );
		$propToolbox->setAccessible( true );

		//checking for $this->app inside controller
		$this->assertInstanceOf( 'WikiaApp', $propApp->getValue( $mock ) );
		$this->assertInstanceOf( get_class( $mockToolbox ), $propToolbox->getValue( $mock ) );


	}

	/**
	 * @covers  HubRssFeedModel::isValidVerticalId
	 */
	public function testIsValidVerticalId() {

		$mockToolbox = $this->mockToolbox->setMethods( ['getVerticalsIds'] )->getMock();

		$mockToolbox->expects( $this->any() )
			->method( 'getVerticalsIds' )
			->will( $this->returnValue( [1, 2, 3] ) );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$refl = new \ReflectionObject($mock);

		$propToolbox = $refl->getProperty( 'marketingToolboxModel' );
		$propToolbox->setAccessible( true );
		$propToolbox->setValue( $mock, $mockToolbox );


		$this->assertTrue( $mock->isValidVerticalId( 1 ) );
		$this->assertFalse( $mock->isValidVerticalId( 5 ) );

	}

	/**
	 * @covers  HubRssFeedModel::getServices
	 */
	public function testGetServices() {

		$mockSlider = $this->getMock( 'MarketingToolboxModuleSliderService', ['__construct'] );
		$mockCommunity = $this->getMock( 'MarketingToolboxModuleFromthecommunityService', ['__construct'] );

		$this->mockClass( 'MarketingToolboxModuleSliderService', $mockSlider );
		$this->mockClass( 'MarketingToolboxModuleFromthecommunityService', $mockCommunity );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$methodServices = $refl->getMethod( 'getServices' );
		$methodServices->setAccessible( true );

		$res = $methodServices->invoke( $mock, [null] );
		$this->assertInstanceOf( get_class( $mockSlider ), $res[ 'slider' ] );
		$this->assertInstanceOf( get_class( $mockCommunity ), $res[ 'community' ] );

	}


	/**
	 * @covers  HubRssFeedModel::getDataFromModules
	 */
	public function testGetDataFromModules() {

		$mockSlider = $this->getMock( 'MarketingToolboxModuleSliderService', ['loadData'] );
		$mockCommunity = $this->getMock( 'MarketingToolboxModuleFromthecommunityService', ['loadData'] );

		$mockSlider->expects( $this->any() )
			->method( 'loadData' )
			->will( $this->returnValue( ['a' => [['shortDesc' => 'a1', 'longDesc' => 'a2', 'photoName' => 'a3', 'articleUrl' => 'a4']]] ) );

		$mockCommunity->expects( $this->any() )
			->method( 'loadData' )
			->will( $this->returnValue( ['a' => [['articleTitle' => 'b1', 'quote' => 'b2', 'photoName' => 'b3', 'url' => 'b4']]] ) );


		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['getServices', 'getThumbData'] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getServices' )
			->will( $this->returnValue( ['slider' => $mockSlider, 'community' => $mockCommunity] ) );

		$tmp = new StdClass();
		$tmp->url = 'xx';
		$tmp->width = 500;
		$tmp->height = 500;
		$mock->expects( $this->any() )
			->method( 'getThumbData' )
			->will( $this->returnValue( $tmp ) );


		$refl = new \ReflectionObject($mock);
		$methodGDFM = $refl->getMethod( 'getDataFromModules' );
		$methodGDFM->setAccessible( true );

		$res = $methodGDFM->invoke( $mock, [null] );

		$this->assertArrayHasKey( 'a4', $res );
		$this->assertEquals( $res[ 'a4' ][ 'title' ], 'a1' );
		$this->assertEquals( $res[ 'a4' ][ 'description' ], 'a2' );
		$this->assertArrayHasKey( 'img', $res[ 'a4' ] );
		$this->assertEquals( $res[ 'a4' ][ 'img' ][ 'url' ], 'xx' );
		$this->assertEquals( $res[ 'a4' ][ 'img' ][ 'width' ], 500 );
		$this->assertEquals( $res[ 'a4' ][ 'img' ][ 'height' ], 500 );

		$this->assertArrayHasKey( 'b4', $res );
		$this->assertEquals( $res[ 'b4' ][ 'title' ], 'b1' );
		$this->assertEquals( $res[ 'b4' ][ 'description' ], 'b2' );
		$this->assertArrayHasKey( 'img', $res[ 'b4' ] );
		$this->assertEquals( $res[ 'b4' ][ 'img' ][ 'url' ], 'xx' );
		$this->assertEquals( $res[ 'b4' ][ 'img' ][ 'width' ], 500 );
		$this->assertEquals( $res[ 'b4' ][ 'img' ][ 'height' ], 500 );


	}

	/**
	 * @covers  HubRssFeedModel::getRealData
	 */
	public function testGetRealData() {
		$mockToolbox = $this->mockToolbox->setMethods( ['getLastPublishedTimestamp'] )->getMock();

		$mockToolbox->expects( $this->any() )
			->method( 'getLastPublishedTimestamp', '__construct' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getLastPublishedTimestamp' ) );

		$this->mockClass( 'MarketingToolboxModel', $mockToolbox );

		$mock = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['getDataFromModules'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty( 'marketingToolboxModel' );
		$prop->setAccessible( true );
		$prop->setValue( $mock, $mockToolbox );

		$mock->expects( $this->any() )
			->method( 'getDataFromModules' )
			->will( $this->returnCallback( 'HubRssModelTest::mock_getDataFromModules' ) );

		$res = $mock->getRealData( 0 );

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

	public static function mock_getDataFromModules( $verticalid, $timestamp = null ) {
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


	public static function mock_getLastPublishedTimestamp( $a, $b, $c, $timestamp ) {
		if ( $timestamp === null ) {
			$timestamp = 1001;
		}
		else {
			$timestamp -= 9;
		}
		return $timestamp;

	}

}