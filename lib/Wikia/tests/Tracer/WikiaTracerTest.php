<?php

use Wikia\Tracer\WikiaTracer;

/**
 * Tests WikiaTracer class
 *
 * @group WikiaTracer
 */
class WikiaTracerTest extends WikiaBaseTest {

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
		$this->assertEquals( $isValid, WikiaTracer::isValidId( $id ) );
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
	 * @param string $caller
	 * @param string $expected
	 * @dataProvider getAppNameFromCallerProvider
	 */
	public function testGetAppNameFromCaller( $caller, $expected ) {
		$this->assertEquals( $expected, WikiaTracer::getAppNameFromCaller( $caller ) );
	}

	public function getAppNameFromCallerProvider() {
		return [
			[
				'Wikia\Service\Helios\HeliosClientImpl:Wikia\Service\Helios\{closure}',
				'Helios'
			],
			[
				'Wikia\Service\Gateway\ConsulUrlProvider:getUrl',
				'ConsulUrlProvider:getUrl'
			]
		];
	}

	/**
	 * @return WikiaTracer
	 */
	private function createNewWikiaTracer() {
		$class = new ReflectionClass(WikiaTracer::class);
		$instance = $class->newInstanceWithoutConstructor();

		$contructor = $class->getConstructor();
		$contructor->setAccessible( true );
		$contructor->invoke($instance);

		return $instance;
	}

	/**
	 * @dataProvider getRequestIdFromData
	 */
	function testGetRequestIdFromHeader( $headerValue, $isUsed ) {
		if ( !empty( $headerValue ) ) {
			$_SERVER['HTTP_X_REQUEST_ID'] = $headerValue;
		}

		$requestId = $this->createNewWikiaTracer()->getTraceId();

		if ( $isUsed ) {
			$this->assertEquals( $headerValue, $requestId );
		}
		else {
			$this->assertNotEquals( 'foo', $requestId );
			$this->assertNotEquals( $headerValue, $requestId );
		}
	}

	/**
	 * @dataProvider getRequestIdFromData
	 */
	function testGetRequestIdFromEnv( $envValue, $isUsed ) {
		if ( !empty( $envValue ) ) {
			$_ENV['WIKIA_TRACER_X_TRACE_ID'] = $envValue;
		}

		$requestId = $this->createNewWikiaTracer()->getTraceId();

		if ( $isUsed ) {
			$this->assertEquals( $envValue, $requestId );
		}
		else {
			$this->assertNotEquals( 'foo', $requestId );
			$this->assertNotEquals( $envValue, $requestId );
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
		$instance = WikiaTracer::instance();
		$this->assertEquals( $instance->getTraceId(), $instance->getTraceId(), 'ID should be the same for the same instance' );

		$this->assertNotEquals( $this->createNewWikiaTracer()->getTraceId(), $this->createNewWikiaTracer()->getTraceId(), 'ID should be different for different instances' );
	}

}
