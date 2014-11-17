<?php

class RssFeedServiceTest extends WikiaBaseTest {

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	/**
	 * @covers  RssFeedService::makeUrlWithRef
	 * @dataProvider makeUrlWithRef_Provider
	 */
	public function testMakeUrlWithRef( $url, $ref, $expected ) {

		$service = new RssFeedService();
		$makeUrlWithRef = self::getFn( $service, 'makeUrlWithRef' );

		$service->setRef( $ref );
		$this->assertEquals( $expected, $makeUrlWithRef( $url ) );

	}

	public function makeUrlWithRef_Provider() {
		return [
			// test correctness for empty values of URL
			// function must always return empty string
			[ '', '', '' ],
			[ '', null, '' ],
			[ null, '', '' ],
			[ null, null, '' ],
			[ '', 'someRef', '' ],
			[ null, 'someRef', '' ],

			// test correctness for empty values of 'ref'
			// function must not affect url
			[ 'http://test.wikia.com', '', 'http://test.wikia.com' ],
			[ 'http://test.wikia.com', null, 'http://test.wikia.com' ],

			// test appending 'ref' to url without parameters
			[ 'http://test.wikia.com', 'ref_value', 'http://test.wikia.com?ref=ref_value' ],
			[ 'http://test.wikia.com', '123', 'http://test.wikia.com?ref=123' ],

			// test appending 'ref' to url with parameters
			[ 'http://test.wikia.com?a=b', 'ref_value', 'http://test.wikia.com?a=b&ref=ref_value' ],
			[ 'http://test.wikia.com?a=b&c=d', '123', 'http://test.wikia.com?a=b&c=d&ref=123' ],
		];
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
