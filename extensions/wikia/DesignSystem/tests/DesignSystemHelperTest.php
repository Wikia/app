<?php
class DesignSystemHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../DesignSystem.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider resolveSvgPathProvider
	 *
	 * @param string $name
	 * @param string $expected
	 */
	public function testResolveSvgPath( $name, $expected ) {
		$method = new ReflectionMethod( 'DesignSystemHelper', 'resolveSvgPath' );
		$method->setAccessible( true );

		$this->assertEquals( $expected, $method->invoke( null, $name ) );
	}

	public function resolveSvgPathProvider() {
		return [
			[
				'name' => 'wds-company-logo-wikia',
				'expected' => 'company/logo-wikia'
			],
			[
				'name' => 'wds-icons-facebook',
				'expected' => 'icons/facebook'
			]
		];
	}
}
