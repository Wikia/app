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
			// methodName, params, encodedParams
			['test', null, null],
			['testParamsOrdered', ['a' => 1, 'b' => 2], '&a=1&b=2'],
			['testParamsUnordered', ['c' => 1, 'a' => 2, 'b' => 3], '&a=2&b=3&c=1']
		];
	}

	/**
	 * @dataProvider getUrlProvider
	 */
	public function testGetUrl( $methodName, $params, $encodedParams ) {
		$className = get_class( $this->dispatchableMock );
		$serverName = "test-server";
		$scriptPath = "/test-path";
		$requestURI = "{$serverName}{$scriptPath}/wikia.php?controller={$className}&method={$methodName}{$encodedParams}";

		$this->mockGlobalVariable( 'wgServer', $serverName );
		$this->mockGlobalVariable( 'wgScriptPath', $scriptPath );

		$this->assertEquals( $requestURI, $className::getUrl( $methodName, $params ) );
	}

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
}