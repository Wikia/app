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

	/**
	 * @return Options
	 */
	protected function getInstance() {
		return new Options();
	}

	public function testBooleanSettersAndGetters() {
		$methods = [
			'setUnknownInvalid' => 'unknownIsInvalid',
			'setLowercaseNames' => 'lowercaseNames',
			'setRawStringInputs' => 'isStringlyTyped',
			'setTrimNames' => 'trimNames',
			'setTrimValues' => 'trimValues',
			'setLowercaseValues' => 'lowercaseValues',
		];

		foreach ( $methods as $setter => $getter ) {
			$options = $this->getInstance();

			foreach ( [ false, true, false ] as $boolean ) {
				call_user_func_array( [ $options, $setter ], [ $boolean ] );

				$this->assertEquals( $boolean, call_user_func( [ $options, $getter ] ) );
			}
		}
	}

	public function testSetAndGetName() {
		$options = $this->getInstance();

		foreach ( [ 'foo', 'bar baz' ] as $name ) {
			$options->setName( $name );
			$this->assertEquals( $name, $options->getName() );
		}
	}

}
