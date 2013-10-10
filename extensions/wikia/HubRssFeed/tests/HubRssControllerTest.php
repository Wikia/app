<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 10:19
 * To change this template use File | Settings | File Templates.
 */


class HubRssControllerTest extends WikiaBaseTest {

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		/*require_once $dir . '../WikiaHubsServices/models/MarketingToolboxModel.class.php';*/
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	/**
	 * @covers  HubRssFeedSpecialController::__construct
	 */
	public function testConstruct() {
		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->setMethods( ['notfound'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty( 'currentTitle' );
		$prop->setAccessible( true );

		$val = $prop->getValue( $mock );
		$this->assertInstanceOf( 'Title', $val );

	}

	/**
	 * @covers  HubRssFeedSpecialController::notfound
	 */
	public function testNotFound() {
		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->disableOriginalConstructor()
			->setMethods( ['__construct', 'setVal'] )
			->getMock();

		$mock->expects( $this->once() )
			->method( 'setVal' )
			->with( 'links', ['abc/Xyz'] );

		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getFullUrl'] )
			->getMock();

		$mockTitle->expects( $this->any() )
			->method( 'getFullUrl' )
			->will( $this->returnValue( 'abc' ) );

		$mock->currentTitle = $mockTitle;

		$mock->hubs = ['xyz' => '...'];

		$mock->wg = new StdClass();

		$mock->notfound();

	}


	/**
	 * @covers  HubRssFeedSpecialController::index
	 */
	public function testIndexNotFound() {
		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->disableOriginalConstructor()
			->setMethods( ['forward', 'setVal'] )
			->getMock();

		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( ['getParams'] )
			->disableOriginalConstructor()
			->getMock();

		$mockRequest->expects( $this->any() )
			->method( 'getParams' )
			->will( $this->returnValue( ['par' => 'XyZ'] ) );

		$mock->expects( $this->once() )
			->method( 'forward' )
			->with( 'HubRssFeedSpecial', 'notfound' );


		$mock->hubs = ['abc' => 'desc_abc'];
		$mock->request = $mockRequest;
		$mock->index();
	}


	/**
	 * @covers  HubRssFeedSpecialController::index
	 */
	public function testIndexCached() {
		return $this->testIndexNotCached( true );
	}

	/**
	 * @covers  HubRssFeedSpecialController::index
	 */
	public function testIndexNotCached( $cached = false ) {
		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->disableOriginalConstructor()
			->setMethods( ['__construct'] )
			->getMock();


		$mockModel = $this->getMockBuilder( 'HubRssFeedModel' )
			->disableOriginalConstructor()
			->setMethods( ['__construct', 'getRealData'] )
			->getMock();


		$mockService = $this->getMockBuilder( 'HubRssFeedService' )
			->setMethods( ['dataToXml'] )
			->disableOriginalConstructor()
			->getMock();

		if ( $cached ) {
			$mockService->expects( $this->never() )
				->method( 'dataToXml' );
			$mockModel->expects( $this->never() )
				->method( 'getRealData' );
		}
		else
		{
			$mockService->expects( $this->any() )
				->method( 'dataToXml' )
				->will( $this->returnValue( '<rss/>' ) );
			$mockModel->expects( $this->once() )
				->method( 'getRealData' )
				->will( $this->returnValue( [''] ) );
		}

		$this->mockClass( 'HubRssFeedService', $mockService );
		$this->mockClass( 'HubRssFeedModel', $mockModel );

		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( ['getParams'] )
			->disableOriginalConstructor()
			->getMock();

		$mockRequest->expects( $this->any() )
			->method( 'getParams' )
			->will( $this->returnValue( ['par' => 'AbC'] ) );

		$mockLang = $this->getMockBuilder( 'Language' )
			->setMethods( ['getCode'] )
			->disableOriginalConstructor()
			->getMock();

		$mockLang->expects( $this->any() )
			->method( 'getCode' )
			->will( $this->returnValue( 'xx' ) );

		$mockMemc = $this->getMockBuilder( 'MemcachedPhpBagOStuff' )
			->setMethods( ['get', 'set'] )
			->disableOriginalConstructor()
			->getMock();

		$mockMemc->expects( $this->any() )
			->method( 'get' )
			->with( 'key' )
			->will( $this->returnValue( $cached ? '<rss-cached/>' : false ) );

		$mockResponse = $this->getMockBuilder( 'WikiaResponse' )
			->setMethods( ['setFormat', 'setBody', 'setContentType'] )
			->disableOriginalConstructor()
			->getMock();

		$mockResponse->expects( $this->any() )
			->method( 'setBody' )
			->with( $cached ? '<rss-cached/>' : '<rss/>' );

		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getFullUrl'] )
			->getMock();

		$this->getGlobalFunctionMock( 'wfMemcKey' )
			->expects( $this->any() )
			->method( 'wfMemcKey' )
			->will( $this->returnValue( 'key' ) );


		$mock->app = new StdClass();
		$mock->app->wg = new StdClass();
		$mock->app->wg->ContLang = $mockLang;

		$mock->currentTitle = $mockTitle;
		$mock->request = $mockRequest;
		$mock->hubs = ['abc' => 'desc_abc'];
		$mock->wg = new StdClass();
		$mock->wg->memc = $mockMemc;

		$mock->response = $mockResponse;

		$mock->index();
	}


}