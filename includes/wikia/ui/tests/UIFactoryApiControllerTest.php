<?php

class UIFactoryApiControllerTest extends WikiaBaseTest {

	/**
	 * @expectedException MissingParameterApiException
	 */
	public function testMissingParameter() {

		$requestMock = $this->getMock( 'WikiaRequest', array( 'getArray' ), array(), '', false );
		$requestMock->expects( $this->any() )
			->method( 'getArray' )
			->will( $this->returnValue([]) );

		$api = new Wikia\UI\UIFactoryApiController();
		$api->setRequest($requestMock);
		$api->getComponentsConfig();

	}

	public function testFactoryInit() {
		$componentNames = [ 'button', 'modal' ];
		$factoryMock = $this->getMock( 'Wikia\\UI\\Factory', array('init', '__wakeup'), array(), '', false );
		$factoryMock->expects( $this->once() )
			->method( 'init' )
			->with( $componentNames )
			->will( $this->returnValue( [] ) );

		$this->mockStaticMethod( 'Wikia\\UI\\Factory', 'getInstance', $factoryMock );

		$requestMock = $this->getMock( 'WikiaRequest', array( 'getArray' ), array(), '', false );
		$requestMock->expects( $this->any() )
			->method( 'getArray' )
			->will( $this->returnValue( $componentNames ) );
		$requestMock->expects( $this->any() )
			->method( 'setVal' );

		$responseMock = $this->getMock( 'WikiaResponse', array( 'setCacheValidity' ), array(), '', false );
		$responseMock->expects( $this->once() )
			->method( 'setCacheValidity' );

		$apiMock = $this->getMock( 'Wikia\\UI\\UIFactoryApiController', [ 'setVal' ] );
		$apiMock->setRequest( $requestMock );
		$apiMock->setResponse( $responseMock );

		$apiMock->getComponentsConfig();
	}

}
