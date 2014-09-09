<?php

class DivContainingHeadersVisitorTest extends WikiaBaseTest {

	//load extension
	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/JsonFormat/JsonFormat.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider getUrlWithoutPathDataProvider
	 */
	public function testGetUrlWithoutPath( $wgArticlePath, $url, $expected ) {
		$divVisitor = new DivContainingHeadersVisitor( new \CompositeVisitor(), new \JsonFormatBuilder() );
		$getUrlWithoutPath = self::getFn( $divVisitor, 'getUrlWithoutPath' );
		$this->assertEquals( $expected, $getUrlWithoutPath( $url, $wgArticlePath ) );
	}

	public function getUrlWithoutPathDataProvider() {
		return [
			[
				'$1',
				'Test',
				'Test'
			],
			[
				'$1',
				'Test?action=render',
				'Test'
			],
			[
				'$1',
				'Test/subTest',
				'Test/subTest'
			],
			[
				'$1',
				'Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/wiki/$1',
				'/wiki/Test',
				'Test'
			],
			[
				'/wiki/$1',
				'/wiki/Test?action=render',
				'Test'
			],
			[
				'/wiki/$1',
				'/wiki/Test/subTest',
				'Test/subTest'
			],
			[
				'/wiki/$1',
				'/wiki/Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/stub',
				'Test'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/stub?action=render',
				'Test'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/subTest/stub',
				'Test/subTest'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/subTest/stub?action=render',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test',
				'Test'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test?action=render',
				'Test'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test/subTest',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/ignore',
				'Test'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/ignore?action=render',
				'Test'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/subTest/ignore',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/subTest/ignore?action=render',
				'Test/subTest'
			],
			[
				'/wiki/$1/stub',
				'',
				null
			],
			[
				'/wiki/$1/stub',
				null,
				null
			],
			[
				null,
				null,
				null
			],
			[
				'',
				'Test',
				'Test'
			],
			[
				null,
				'Test',
				'Test'
			],
			[
				'without sequential characters $ and 1 - which is not a valid case for Wikia stack',
				'Test/subTest',
				'Test/subTest'
			],
			[
				// very artificial test case
				'/wiki/$1/stub',
				// sub-article has such title, as right piece of $wgArticlePath
				'/wiki/Test/subTest/stub/stub',
				'Test/subTest/stub'
			],
			[
				// very artificial test case
				'/wiki/$1/stub',
				// sub-article has such title, as right piece of $wgArticlePath
				'/wiki/Test/subTest/stub/stub?action=render',
				'Test/subTest/stub'
			],
		];
	}

	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class( $obj ) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

}
