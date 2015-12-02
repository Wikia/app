<?php

namespace DMCARequest\Test;

use DMCARequest\ChillingEffectsClient;

class ChillingEffectsClientTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../DMCARequest.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getNoticeIdFromResponseProvider
	 */
	public function testGetNoticeIdFromResponse( $locationHeader, $expectedResult ) {
		$httpRequestMock = $this->getMock( '\MWHttpRequest', [ 'getResponseHeader' ] );

		$httpRequestMock->expects( $this->once() )
			->method( 'getResponseHeader' )
			->with( 'Location' )
			->will( $this->returnValue( $locationHeader ) );

		$client = new ChillingEffectsClient( '', '' );

		$result = $client->getNoticeIdFromResponse( $httpRequestMock );

		$this->assertEquals( $result, $expectedResult );
	}

	public function getNoticeIdFromResponseProvider() {
		return [
			[ null, false ],
			[ 'http://localhost/notices/1234', 1234 ],
			[ 'http://localhost/notices/', false ],
			[ 'http://localhost/foo', false ],
			[ 'http://localhost', false ],
			[ '', false ],
		];
	}
}
