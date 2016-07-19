<?php

use Wikia\Tracer\RequestId;

/**
 * Tests RequestId class
 *
 * @group WikiaTracer
 */
class RequestIdTest extends WikiaBaseTest {

	private $envOriginal;
	private $serverOriginal;

	function setUp() {
		parent::setUp();
		$this->envOriginal = $_ENV;
		$this->serverOriginal = $_SERVER;
	}

	function tearDown() {
		parent::tearDown();
		$_ENV = $this->envOriginal;
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
				'id' => 'mw5405bb3c76f364.47661604', // the legacy ID
				'valid' => false,
			],
			[
				'id' => 'd09dd88e-f1a6-11e5-8db2-00163e046284',
				'valid' => true,
			],
		];
	}

	/**
	 * @dataProvider getRequestIdFromData
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

	/**
	 * @dataProvider getRequestIdFromData
	 */
	function testGetRequestIdFromEnv( $envValue, $isUsed ) {
		if ( !empty( $envValue ) ) {
			$_ENV['WIKIA_TRACER_X_TRACE_ID'] = $envValue;
		}

		$requestId = ( new RequestId() )->getRequestId();

		if ( $isUsed ) {
			$this->assertEquals( $envValue, $requestId );
		}
		else {
			$this->assertNotEquals( 'foo', $requestId );
		}
	}

	function getRequestIdFromData() {
		return [
			[
				'value' => false,
				'isUsed' => false,
			],
			[
				'value' => 'foo',
				'isUsed' => false,
			],
			[
				'value' => 'mw5405bb3d129e76.46189257', // the legacy ID
				'isUsed' => false,
			],
			[
				'value' => 'd09dd88e-f1a6-11e5-8db2-00163e046284',
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
