<?php

namespace ParamProcessor\Tests;

use ParamProcessor\Options;

/**
 * @covers ParamProcessor\Options
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class OptionsTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$this->assertInstanceOf( 'ParamProcessor\Options', new Options() );
	}

	/**
	 * @return Options
	 */
	protected function getInstance() {
		return new Options();
	}

	public function testBooleanSettersAndGetters() {
		$methods = array(
			'setUnknownInvalid' => 'unknownIsInvalid',
			'setLowercaseNames' => 'lowercaseNames',
			'setRawStringInputs' => 'isStringlyTyped',
			'setTrimNames' => 'trimNames',
			'setTrimValues' => 'trimValues',
			'setLowercaseValues' => 'lowercaseValues',
		);

		foreach ( $methods as $setter => $getter ) {
			$options = $this->getInstance();

			foreach ( array( false, true, false ) as $boolean ) {
				call_user_func_array( array( $options, $setter ), array( $boolean ) );

				$this->assertEquals( $boolean, call_user_func( array( $options, $getter ) ) );
			}
		}
	}

	public function testSetAndGetName() {
		$options = $this->getInstance();

		foreach ( array( 'foo', 'bar baz' ) as $name ) {
			$options->setName( $name );
			$this->assertEquals( $name, $options->getName() );
		}
	}

}
