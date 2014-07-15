<?php

class RssFeedServiceTest extends WikiaBaseTest {

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	/**
	 * @covers  RssFeedService::makeUrlWithRef
	 */
	public function testConstruct() {
		$service = new RssFeedService();
		$makeUrlWithRef = self::getFn( $service, 'makeUrlWithRef' );

		// Test case, when $ref is empty
		// Urls must not be changed
		$service->setRef( '' );

		$this->assertEquals( '', $makeUrlWithRef( '' ) );

		$this->assertEquals(
			'http://test.wikia.com',
			$makeUrlWithRef( 'http://test.wikia.com' ) );

		$this->assertEquals(
			'http://test.wikia.com?key=value',
			$makeUrlWithRef( 'http://test.wikia.com?key=value' ) );

		// Test case, when $ref is not empty
		// parameter 'ref' must be appended to url
		$service->setRef( 'some_ref_value' );

		// Empty urls must not be affected
		$this->assertEquals( '', $makeUrlWithRef( '' ) );

		// Appending parameter 'ref' to url without parameters
		$this->assertEquals(
			'http://test.wikia.com?ref=some_ref_value',
			$makeUrlWithRef( 'http://test.wikia.com' ) );

		// Appending parameter 'ref' to url which already contains parameters
		$this->assertEquals(
			'http://test.wikia.com?key=value&ref=some_ref_value',
			$makeUrlWithRef( 'http://test.wikia.com?key=value' ) );

		$this->assertEquals(
			'http://test.wikia.com?key=value&test=test&ref=some_ref_value',
			$makeUrlWithRef( 'http://test.wikia.com?key=value&test=test' ) );
	}

	protected static function getFn($obj, $name) {
		$class = new ReflectionClass(get_class($obj));
		$method = $class->getMethod($name);
		$method->setAccessible(true);

		return function () use ($obj, $method) {
			$args = func_get_args();
			return $method->invokeArgs($obj, $args);
		};
	}

} 