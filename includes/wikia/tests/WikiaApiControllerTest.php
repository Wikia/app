<?php

class WikiaApiControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var Boolean
	 */
	private $org_wgApiDisableImages;

	public function setUp() {
		global $wgApiDisableImages;
		$this->org_wgApiDisableImages = $wgApiDisableImages;
		parent::setUp();
	}

	public function tearDown() {
		global $wgApiDisableImages;
		$wgApiDisableImages = $this->org_wgApiDisableImages;
		parent::tearDown();
	}

	/**
	 * @covers WikiaApiController::hideNonCommercialContent
	 */
	public function test_hideNonCommercialContent() {
		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/v1...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertTrue($controller->hideNonCommercialContent(), "This request should allowed only content".
											" that may be used commercially");	

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/wikia.php?...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertFalse($controller->hideNonCommercialContent(), "This request should have allowed all content");											
	}

	/**
	 * @covers WikiaApiController::getApiVersion
	 */
	public function test_getApiVersion() {
		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/v1...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), 1);

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/wikia.php?...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), WikiaApiController::API_ENDPOINT_INTERNAL );

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/test...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), WikiaApiController::API_ENDPOINT_TEST );
	}

	/**
	 * @covers WikiaApiController::serveImages
	 */
	public function testServeImages() {
		global $wgApiDisableImages;

		$mock = $this->getMockBuilder( 'WikiaApiController' )
			->setMethods( [ '__construct', 'getApiVersion' ] )
			->disableOriginalConstructor()
			->getMock();

		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'isInternal' ] )
			->disableOriginalConstructor()
			->getMock();
		//0
		$mockRequest->expects( $this->at( 0 ) )
			->method( 'isInternal' )
			->will( $this->returnValue( false ) );
		$mock->expects( $this->at( 0 ) )
			->method( 'getApiVersion' )
			->will( $this->returnValue( WikiaApiController::API_ENDPOINT_TEST ) );
		//1
		$mockRequest->expects( $this->at( 1 ) )
			->method( 'isInternal' )
			->will( $this->returnValue( false ) );
		$mock->expects( $this->at( 1 ) )
			->method( 'getApiVersion' )
			->will( $this->returnValue( WikiaApiController::API_ENDPOINT_TEST ) );
		//2
		$mockRequest->expects( $this->at( 2 ) )
			->method( 'isInternal' )
			->will( $this->returnValue( true ) );
		//3
		$mockRequest->expects( $this->at( 3 ) )
			->method( 'isInternal' )
			->will( $this->returnValue( false ) );
		$mock->expects( $this->at( 2 ) )
			->method( 'getApiVersion' )
			->will( $this->returnValue( WikiaApiController::API_ENDPOINT_INTERNAL ) );

		$mock->setRequest( $mockRequest );
		$refl = new ReflectionMethod( $mock, 'serveImages' );
		$refl->setAccessible( true );

		//0
		$wgApiDisableImages = false;
		$this->assertTrue( $refl->invoke( $mock ) );
		//1
		$wgApiDisableImages = true;
		$this->assertFalse( $refl->invoke( $mock ) );
		//2 now isInternal will return true
		$wgApiDisableImages = true;
		$this->assertTrue( $refl->invoke( $mock ) );
		//3 now isInternal will return false, but getApiVersion will return 'internal'
		$wgApiDisableImages = true;
		$this->assertTrue( $refl->invoke( $mock ) );
	}

	/**
	 * @covers WikiaApiController::setResponseData
	 * @dataProvider setResponse_Provider
	 */
	public function testSetResponseData( $data, $fields, $expected, $refValue, $serveImages, $cacheValid = 0 ) {
		$mock = $this->getMockBuilder( 'WikiaApiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'serveImages', 'getRequest', 'getResponse' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'serveImages' )
			->will( $this->returnValue( $serveImages ) );

		$mockResponse = $this->getMockBuilder( 'StdClass' )
			->setMethods( [ 'setData', 'setCacheValidity' ] )
			->getMock();

		$mockResponse->expects( $this->once() )
			->method( 'setData' )
			->with( $expected );

		if ( $cacheValid > 0 ) {
			$mockResponse->expects( $this->once() )
				->method( 'setCacheValidity' )
				->with( $cacheValid );
		}

		$mockResponse->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( null ) );

		$mockRequest = $this->getMockBuilder( 'StdClass' )
			->setMethods( [ 'getVal' ] )
			->getMock();

		if ( $refValue ) {
			$mockRequest->expects( $this->any() )
				->method( 'getVal' )
				->with( WikiaApiController::REF_URL_ARGUMENT )
				->will( $this->returnValue( $refValue ) );
		} else {
			$mockRequest->expects( $this->any() )
				->method( 'getVal' )
				->with( WikiaApiController::REF_URL_ARGUMENT )
				->will( $this->returnValue( null ) );
		}

		$mockRequest->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( null ) );

		$mock->expects( $this->any() )
			->method( 'getResponse' )
			->will( $this->returnValue( $mockResponse ) );

		$mock->expects( $this->any() )
			->method( 'getRequest' )
			->will( $this->returnValue( $mockRequest ) );

		$method = new ReflectionMethod( $mock, 'setResponseData' );
		$method->setAccessible( true );

		$method->invoke( $mock, $data, $fields, $cacheValid );
	}

	public function setResponse_Provider() {
		return [
			[
				[ "items" => [ [ 'title' => 't0', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't0', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				null,
				true,
				12334
			],
			[
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				null,
				true
			],
			[
				[ "items" => [ [ 'title' => 't2', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't2', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				null,
				true
			],
			//now call it like ....?ref=noideawhat
			[
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				'noideawhat',
				true
			],
			[
				[ "items" => [ [ 'title' => 't3', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't3', 'url' => 'http://a2.a?ref=noideawhat', 'img' => 'www.img2.a/a.png?ref=noideawhat' ] ] ],
				'noideawhat',
				true
			],
			[
				[ "items" => [ [ 'title' => 't4', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png?par=val' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't4', 'url' => 'http://a2.a?ref=noideawhat', 'img' => 'www.img2.a/a.png?par=val&ref=noideawhat' ] ] ],
				'noideawhat',
				true
			],
			[
				[ "items" => [ [ 'title' => 't5', 'url' => [ 'http://a2.a' ], 'img' => 'www.img2.a/a.png?par=val' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't5', 'url' => [ 'http://a2.a?ref=noideawhat' ], 'img' => 'www.img2.a/a.png?par=val&ref=noideawhat' ] ] ],
				'noideawhat',
				true
			],
			//now call it like ....?ref=noideawhat AND disable images
			[
				[ "items" => [ [ 'title' => 't6', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't6', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				'noideawhat',
				false
			],
			[
				[ "items" => [ [ 'title' => 't8', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't8', 'url' => 'http://a2.a?ref=noideawhat', 'img' => null ] ] ],
				'noideawhat',
				false
			],
			[
				[ "items" => [ [ 'title' => 't9', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png?par=val' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't9', 'url' => 'http://a2.a?ref=noideawhat', 'img' => null ] ] ],
				'noideawhat',
				false
			],
			[
				[ "items" => [ [ 'title' => 't10', 'url' => 'http://a2.a', 'img' => [ 'www.img2.a/a.png?par=val' ] ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't10', 'url' => 'http://a2.a?ref=noideawhat', 'img' => [ ] ] ] ],
				'noideawhat',
				false
			],
		];
	}

}
