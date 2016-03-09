<?php

class PortableInfoboxBuilderHooksTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfoboxBuilder.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider titleTextProvider
	 */
	public function testGetUrlPath( $titleText, $expected ) {
		$reflectionMethod = new ReflectionMethod( 'PortableInfoboxBuilderHooks', 'getUrlPath' );
		$reflectionMethod->setAccessible( true );
		$this->assertEquals( $expected, $reflectionMethod->invoke( null, $titleText ) );
	}

	/**
	 * @dataProvider requestModeProvider
	 */
	public function testForcedSourceModeTest( $queryStringValue, $expectedResult ) {
		$reflectionMethod = new ReflectionMethod( 'PortableInfoboxBuilderHooks', 'isForcedSourceMode' );
		$reflectionMethod->setAccessible( true );

		$requestMock = $this->getMockBuilder( 'WebRequest' )->setMethods( [ 'getVal' ] )->getMock();
		$requestMock->expects( $this->any() )->method( 'getVal' )->willReturn( $queryStringValue );

		$this->assertEquals( $expectedResult, $reflectionMethod->invoke( null, $requestMock ) );
	}

	public function titleTextProvider() {
		return [
			[ '', ''],
			[ 'Special:InfoboxBuilder', '' ],
			[ 'Special:InfoboxBuilder/', '' ],
			[ 'Special:InfoboxBuilder/TemplateName', 'TemplateName' ],
			[ 'Special:InfoboxBuilder/TemplateName/Subpage', 'TemplateName/Subpage' ]
		];
	}

	public function requestModeProvider() {
		return [
			[ 'source', true ],
			[ 'mediawiki', false ],
			[ '', false ],
			[ null, false ]
		];
	}
}
