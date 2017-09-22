<?php

namespace ParamProcessor\Tests;

use ParamProcessor\Settings;

/**
 * @covers ParamProcessor\Settings
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SettingsTest extends \PHPUnit_Framework_TestCase {

	public function constructorProvider() {
		$settingArrays = [
			[ [] ],
			[ [ 'foo' => 'bar' ] ],
			[ [ 'foo' => 'bar', 'baz' => 'BAH' ] ],
			[ [ '~[,,_,,]:3' => [ 9001, 4.2 ] ] ],
		];

		return $settingArrays;
	}

	/**
	 * @dataProvider constructorProvider
	 *
	 * @param array $settings
	 */
	public function testConstructor( array $settings ) {
		$settingsObject = new Settings( $settings );

		foreach ( $settings as $name => $value ) {
			$this->assertEquals( $value, $settingsObject->get( $name ) );
		}

		$this->assertTrue( true );
	}

}
