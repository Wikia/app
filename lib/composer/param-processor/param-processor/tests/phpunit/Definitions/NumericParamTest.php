<?php

namespace ParamProcessor\Tests\Definitions;

use ParamProcessor\Options;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class NumericParamTest extends ParamDefinitionTest {

	public function lowerBoundProvider() {
		return [
			[ 42, 42, true ],
			[ 42, 41, false ],
			[ 42, 43, true ],
			[ false, 43, true ],
			[ false, 0, true ],
			[ false, -100, true ],
			[ -100, -100, true ],
			[ -99, -100, false ],
			[ -101, -100, true ],
		];
	}

	/**
	 * @dataProvider lowerBoundProvider
	 */
	public function testSetLowerBound( $bound, $testValue, $validity ) {
		$definition = $this->getEmptyInstance();
		$definition->setArrayValues( [ 'lowerbound' => $bound ] );

		$this->validate( $definition, (string)$testValue, $validity );

		$options = new Options();
		$options->setRawStringInputs( false );
		$this->validate( $definition, $testValue, $validity, $options );
	}

	public function upperBoundProvider() {
		return [
			[ 42, 42, true ],
			[ 42, 41, true ],
			[ 42, 43, false ],
			[ false, 43, true ],
			[ false, 0, true ],
			[ false, -100, true ],
			[ -100, -100, true ],
			[ -99, -100, true ],
			[ -101, -100, false ],
		];
	}

	/**
	 * @dataProvider upperBoundProvider
	 */
	public function testSetUpperBound( $bound, $testValue, $validity ) {
		$definition = $this->getEmptyInstance();
		$definition->setArrayValues( [ 'upperbound' => $bound ] );

		$this->validate( $definition, (string)$testValue, $validity );

		$options = new Options();
		$options->setRawStringInputs( false );
		$this->validate( $definition, $testValue, $validity, $options );
	}

}
