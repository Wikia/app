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

	public function titleTextProvider() {
		return [
			[ '', ''],
			[ 'Special:InfoboxBuilder', '' ],
			[ 'Special:InfoboxBuilder/', '' ],
			[ 'Special:InfoboxBuilder/TemplateName', 'TemplateName' ],
			[ 'Special:InfoboxBuilder/TemplateName/Subpage', 'TemplateName/Subpage' ]
		];
	}
}
