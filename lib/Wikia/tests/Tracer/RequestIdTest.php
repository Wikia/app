<?php

use Wikia\Tracer\RequestId;

/**
 * Tests RequestId class
 */
class RequestIdTest extends WikiaBaseTest {

	private $serverOriginal;

	function setUp() {
		parent::setUp();
		$this->serverOriginal = $_SERVER;
	}

	function tearDown() {
		parent::tearDown();
		$_SERVER = $this->serverOriginal;
	}

	/**
	 * @dataProvider isValidIdData
	 */
	function testIsValidId( $id, $isValid ) {
		$this->assertEquals( $isValid, RequestId::isValidId( $id ) );
	}

	function isValidIdData() {
		return [
			[
				'id' => 123,
				'valid' => false,
			],
			[
				'id' => '123',
				'valid' => false,
			],
			[
				'id' => 'mw5405bb3c76f364.47661604',
				'valid' => true,
			],
		];
	}

	/**
	 * @dataProvider getRequestIdFromHeaderData
	 */
	function testGetRequestIdFromHeader( $headerValue, $isUsed ) {
		if ( !empty( $headerValue ) ) {
			$_SERVER['HTTP_X_REQUEST_ID'] = $headerValue;
		}

		$requestId = ( new RequestId() )->getRequestId();

		if ( $isUsed ) {
			$this->assertEquals( $headerValue, $requestId );
		}
		else {
			$this->assertNotEquals( 'foo', $requestId );
		}
	}

	function getRequestIdFromHeaderData() {
		return [
			[
				'headerValue' => false,
				'isUsed' => false,
			],
			[
				'headerValue' => 'foo',
				'isUsed' => false,
			],
			[
				'headerValue' => 'mw5405bb3d129e76.46189257',
				'isUsed' => true,
			],
		];
	}

	function testSingleton() {
		$instance = RequestId::instance();
		$this->assertEquals( $instance->getRequestId(), $instance->getRequestId(), 'ID should be the same for the same instance' );

		$this->assertNotEquals( ( new RequestId() )->getRequestId(), ( new RequestId() )->getRequestId(), 'ID should be different for different instances' );
	}

}
