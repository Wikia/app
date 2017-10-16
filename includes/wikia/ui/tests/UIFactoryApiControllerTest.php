<?php

class UIFactoryApiControllerTest extends WikiaBaseTest {

	/**
	 * @expectedException MissingParameterApiException
	 */
	public function testMissingParameter() {

		$requestMock = $this->getMock( 'WikiaRequest', [ 'getArray' ], [], '', false );
		$requestMock->expects( $this->any() )
			->method( 'getArray' )
			->will( $this->returnValue( [] ) );

		$api = new Wikia\UI\UIFactoryApiController();
		$api->setRequest( $requestMock );
		$api->getComponentsConfig();

	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03707 ms
	 */
	public function testFactoryInit() {
		$componentNames = [ 'button', 'modal' ];
		$factoryMock = $this->getMock( 'Wikia\UI\Factory', [ 'init', '__wakeup' ], [], '', false );
		$factoryMock->expects( $this->once() )
			->method( 'init' )
			->with( $componentNames )
			->will( $this->returnValue( [] ) );

		$this->mockStaticMethod( 'Wikia\UI\Factory', 'getInstance', $factoryMock );

		$requestMock = $this->getMock( 'WikiaRequest', [ 'getArray' ], [], '', false );
		$requestMock->expects( $this->any() )
			->method( 'getArray' )
			->with( 'components' )
			->will( $this->returnValue( $componentNames ) );

		$responseMock = $this->getMock( 'WikiaResponse', [ 'setCacheValidity' ], [], '', false );
		$responseMock->expects( $this->once() )
			->method( 'setCacheValidity' );

		$api = new Wikia\UI\UIFactoryApiController();
		$api->setRequest( $requestMock );
		$api->setResponse( $responseMock );

		$api->getComponentsConfig();

		$this->assertEquals( [], $responseMock->getVal( 'components' )  );
		$this->assertEquals( [], $responseMock->getVal( 'dependencies' )  );
	}

}
