<?php
/**
 * Unit test for WikiaDispatchableObject
 */

class WikiaDispatchableObjectTest extends WikiaBaseTest {
	private $dispatchableMock = null;

	protected function setUp() {
		parent::setUp();

		$this->dispatchableMock = $this->getMockBuilder( 'WikiaDispatchableObject' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();
	}

	//data provider for testGetUrl
	public function getUrlProvider() {
		return [
			// methodName, params, format, encodedParams
			['test', null, null, null],
			['testParamsOrdered', ['a' => 1, 'b' => 2], null, '&a=1&b=2'],
			['testParamsUnordered', ['c' => 1, 'a' => 2, 'b' => 3], null, '&a=2&b=3&c=1'],
			['testParamsUnordered', ['c' => 1, 'a' => 2, 'b' => 3], WikiaResponse::FORMAT_JSON, '&a=2&b=3&c=1&format=json'],
			['testParamsUnordered', ['c' => 1, 'a' => 2, 'b' => 3], WikiaResponse::FORMAT_JSONP, '&a=2&b=3&c=1&format=jsonp'],
			['testParamsUnordered', ['c' => 1, 'a' => 2, 'b' => 3], WikiaResponse::FORMAT_RAW, '&a=2&b=3&c=1&format=raw'],
		];
	}

	/**
	 * @dataProvider getUrlProvider
	 */
	public function testGetUrl( $methodName, $params, $format, $encodedParams ) {
		$className = get_class( $this->dispatchableMock );
		$serverName = "test-server";
		$scriptPath = "/test-path";
		$requestURI = "{$serverName}{$scriptPath}/wikia.php?controller={$className}&method={$methodName}{$encodedParams}";

		$this->mockGlobalVariable( 'wgServer', $serverName );
		$this->mockGlobalVariable( 'wgScriptPath', $scriptPath );

		$this->assertEquals( $requestURI, $className::getUrl( $methodName, $params, $format ) );
	}

	/**
	 * @dataProvider getUrlProvider
	 */
	public function testGetLocalUrl( $methodName, $params, $format, $encodedParams ) {
		$className = get_class( $this->dispatchableMock );
		$requestURI = "/wikia.php?controller={$className}&method={$methodName}{$encodedParams}";

		$this->assertEquals( $requestURI, $className::getLocalUrl( $methodName, $params, $format ) );
	}

	/**
	 * @dataProvider getUrlProvider
	 */
	public function testGetNoCookieUrl( $methodName, $params, $format, $encodedParams ) {
		$className = get_class( $this->dispatchableMock );
		$mockCdnApiUrl = "api.nocookie.test-server";
		$scriptPath = "/test-path";
		$requestURI = "{$mockCdnApiUrl}{$scriptPath}/wikia.php?controller={$className}&method={$methodName}{$encodedParams}";

		$this->mockGlobalVariable( 'wgCdnApiUrl', $mockCdnApiUrl );
		$this->mockGlobalVariable( 'wgScriptPath', $scriptPath );

		$this->assertEquals( $requestURI, $className::getNoCookieUrl( $methodName, $params, $format ) );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0102 ms
	 */
	public function testPurgeUrl() {
		$className = get_class( $this->dispatchableMock );
		$serverName = "test-server";
		$scriptPath = "/test-path";
		$baseURI = "{$serverName}{$scriptPath}/wikia.php?controller={$className}&method=";

		$squidMock =  $this->getMockBuilder( 'SquidUpdate' )
			->disableOriginalConstructor()
			->getMock();
		$squidMock->expects( $this->exactly( 5 ) )
			->method( 'doUpdate' );
		$this->mockClass( 'SquidUpdate', $squidMock );

		$this->mockGlobalVariable( 'wgServer', $serverName );
		$this->mockGlobalVariable( 'wgScriptPath', $scriptPath );

		$this->assertEquals(
			[$baseURI . 'test'],
			$className::purgeMethod( 'test' )
		);
		$this->assertEquals(
			[$baseURI . 'testParams&a=1&b=2'],
			$className::purgeMethod( 'testParams', ['a' => 1, 'b' => 2] )
		);

		$this->assertEquals(
			[$baseURI . 'testVariants&a=1&b=2', $baseURI . 'testVariants&c=3&d=4'],
			$className::purgeMethodVariants( 'testVariants', [['a' => 1, 'b' => 2], ['c' => 3, 'd' => 4]] )
		);

		$this->assertEquals(
			[$baseURI . 'testMultiple1&a=1&b=2', $baseURI . 'testMultiple2&c=3&d=4'],
			$className::purgeMethods( [['testMultiple1', ['a' => 1, 'b' => 2]], ['testMultiple2', ['c' => 3, 'd' => 4]]] )
		);
		$this->assertEquals(
			[$baseURI . 'testMultiple3', $baseURI . 'testMultiple4'],
			$className::purgeMethods( ['testMultiple3', 'testMultiple4'] )
		);
	}

	/**
	 * @dataProvider checkWriteRequestProvider
	 */
	public function testCheckWriteRequest( $params, $wasPosted, $token, $exceptionExpected ) {
		$requestMock = $this->getMock( 'WikiaRequest', [ 'wasPosted' ], [ $params ] );
		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->will( $this->returnValue( $wasPosted ) );

		$userMock = $this->getMock( 'User', [ 'getEditToken' ] );
		$userMock->expects( $this->any() )
			->method( 'getEditToken' )
			->will( $this->returnValue( $token ) );

		$dispatchableObjectMock = $this->getMockBuilder( 'WikiaDispatchableObject' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$dispatchableObjectMock->setRequest( $requestMock );
		$dispatchableObjectMock->wg->User = $userMock;

		if ( $exceptionExpected ) {
			$this->setExpectedException( 'BadRequestException' );
		}

		$dispatchableObjectMock->checkWriteRequest();
	}

	public function checkWriteRequestProvider() {
		return [
			[ [ 'token' => '1234' ], true, '1234', false ],
			[ [], true, '1234', true ],
			[ [], false, '1234', true ],
			[ [ 'token' => '4321' ], true, '1234', true ],
			[ [ 'token' => '1234' ], false, '1234', true ],
		];
	}
}
