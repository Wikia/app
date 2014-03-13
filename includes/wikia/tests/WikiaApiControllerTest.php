<?php

class WikiaAppControllerTest extends PHPUnit_Framework_TestCase {
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
		$this->assertEquals($controller->getApiVersion(), 'internal');

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/test...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), 'test');
	}

	/**
	 * @covers WikiaApiController::serveImages
	 */
	public function testServeImages() {
		global $wgApiDisableImages;

		$mock = $this->getMockBuilder( 'WikiaApiController' )
			->setMethods( [ '__construct' ] )
			->disableOriginalConstructor()
			->getMock();
		$refl = new ReflectionMethod( $mock, 'serveImages' );
		$refl->setAccessible( true );
		$wgApiDisableImages = false;
		$this->assertTrue( $refl->invoke( $mock ) );
		$wgApiDisableImages = true;
		$this->assertFalse( $refl->invoke( $mock ) );
	}

	/**
	 * @covers WikiaApiController::setResponseData
	 * @dataProvider dp_setResponseData
	 */
	public function testSetResponseData( $data, $imageFields, $serveImages, $cacheValidity, $expectedDataOut ) {
		$responseMock = $this->getMockBuilder( 'WikiaResponse' )
			->setMethods( [ 'setData', 'setCacheValidity' ] )
			->disableOriginalConstructor()
			->getMock();

		$mock = $this->getMockBuilder( 'WikiaApiController' )
			->setMethods( [ '__construct', 'serveImages' ] )
			->disableOriginalConstructor()
			->getMock();

		$mock->expects( $this->once() )
			->method( 'serveImages' )
			->will( $this->returnValue( $serveImages ) );

		if ( $cacheValidity ) {
			$responseMock->expects( $this->once() )
				->method( 'setCacheValidity' )
				->with( $cacheValidity );
		} else {
			$responseMock->expects( $this->never() )
				->method( 'setCacheValidity' );
		}

		$responseMock->expects( $this->once() )
			->method( 'setData' )
			->with( $expectedDataOut );
		$mock->setResponse( $responseMock );
		$refl = new ReflectionMethod( $mock, 'setResponseData' );
		$refl->setAccessible( true );
		$refl->invoke( $mock, $data, $imageFields, $cacheValidity );
	}

	public function dp_setResponseData() {
		return [
			//test for cache sets
			[ [ ], '', true, 0, [ ] ],
			[ [ ], '', true, 123456, [ ] ],
			//test for removing images
			[ [ 'A' => 'a', 'B' => [ 'b', 'c' ], 'D' => 'd' ], 'D', false, 0, [ 'A' => 'a', 'B' => [ 'b', 'c' ], 'D' => null ] ],
			[ [ 'A' => 'a', 'B' => [ 'b', 'c' ], 'D' => 'd' ], [ 'A', 'B' ], false, 0, [ 'A' => null, 'B' => [ ], 'D' => 'd' ] ],
			[ [ 'A' => 'a', 'B' => [ 'b', 'c' ], 'D' => 'd' ], '', false, 0, [ 'A' => 'a', 'B' => [ 'b', 'c' ], 'D' => 'd' ] ]
		];
	}
}
