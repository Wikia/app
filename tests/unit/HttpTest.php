<?php

class HttpTest extends WikiaBaseTest {

	const HTTP_CONTENT = 'HTTP Success Response';

	/**
	 * Tests request without any additional options with successful response
	 */
	public function testRequest_success() {
		$requestMock = $this->getMock( 'PhpHttpRequest', [ 'execute', 'getContent' ] );
		$requestMock->expects( $this->once() )
			->method( 'execute' )
			->will( $this->returnValue( $this->getStatusMock( self::HTTP_CONTENT ) ) );
		$requestMock->expects( $this->once() )
			->method( 'getContent' )
			->will( $this->returnValue( 'HTTP Success Response' ) );

		$this->mockMWHttpRequestFactory( $requestMock );

		$this->assertEquals( 'HTTP Success Response', Http::request( 'GET', 'http://wikia.com' ) );
	}

	/**
	 * Tests request without any additional options with error in response
	 */
	public function testRequest_error() {
		$requestMock = $this->getMock( 'PhpHttpRequest', [ 'execute' ] );

		$requestMock->expects( $this->once() )
			->method( 'execute' )
			->will( $this->returnValue( $this->getStatusMock( self::HTTP_CONTENT ) ) );

		$this->mockMWHttpRequestFactory( $requestMock );

		$this->assertEquals( false, Http::request( 'GET', 'http://wikia.com' ) );
	}

	private function getStatusMock( $returnValue ) {
		$statusMock = $this->getMock( 'Status', [ 'isOK' ] );
		$statusMock->expects( $this->once() )
			->method( 'isOK' )
			->will( $this->returnValue( $returnValue ) );

		return $statusMock;
	}

	private function mockMWHttpRequestFactory( $requestMock ) {
		$this->getStaticMethodMock(
			'MWHttpRequest',
			'factory'
		)->expects( $this->once() )
			->method( 'factory' )
			->will( $this->returnValue( $requestMock ) );
	}

}
