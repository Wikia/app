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
	public function testGetUrlWithoutPath( $test ) {
		$divVisitor = new DivContainingHeadersVisitor( new \CompositeVisitor(), new \JsonFormatBuilder() );
		$getUrlWithoutPath = self::getFn( $divVisitor, 'getUrlWithoutPath' );
		$this->assertEquals( $test[ 'expected' ], $getUrlWithoutPath( $test[ 'url' ], $test[ 'wgArticlePath' ] ) );
	}

	public function getUrlWithoutPathDataProvider() {
		return [
			[
				'wgArticlePath' => '$1',
				'url' => 'Test',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => '$1',
				'url' => 'Test?action=render',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => '$1',
				'url' => 'Test/subTest',
				'expected' => 'Test/subTest'
			],
			[
				'wgArticlePath' => '$1',
				'url' => 'Test/subTest?action=render',
				'expected' => 'Test/subTest'
			],
			[
				'wgArticlePath' => '/wiki/$1',
				'url' => '/wiki/Test',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => '/wiki/$1',
				'url' => '/wiki/Test?action=render',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => '/wiki/$1',
				'url' => '/wiki/Test/subTest',
				'expected' => 'Test/subTest'
			],
			[
				'wgArticlePath' => '/wiki/$1',
				'url' => '/wiki/Test/subTest?action=render',
				'expected' => 'Test/subTest'
			],
			[
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '/wiki/Test/stub',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '/wiki/Test/stub?action=render',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '/wiki/Test/subTest/stub',
				'expected' => 'Test/subTest'
			],
			[
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '/wiki/Test/subTest/stub?action=render',
				'expected' => 'Test/subTest'
			],
			[
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '',
				'expected' => null
			],
			[
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => null,
				'expected' => null
			],
			[
				'wgArticlePath' => null,
				'url' => null,
				'expected' => null
			],
			[
				'wgArticlePath' => '',
				'url' => 'Test',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => null,
				'url' => 'Test',
				'expected' => 'Test'
			],
			[
				'wgArticlePath' => 'without sequential characters $ and 1 - which is not a valid case for Wikia stack',
				'url' => 'Test/subTest',
				'expected' => 'Test/subTest'
			],
			[
				// very artificial test case
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '/wiki/Test/subTest/stub/stub',
				'expected' => 'Test/subTest/stub'
			],
			[
				// very artificial test case
				'wgArticlePath' => '/wiki/$1/stub',
				'url' => '/wiki/Test/subTest/stub/stub?action=render',
				'expected' => 'Test/subTest/stub'
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
