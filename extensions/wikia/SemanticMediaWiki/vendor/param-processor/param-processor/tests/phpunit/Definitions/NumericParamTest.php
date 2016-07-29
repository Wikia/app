<?php

namespace ParamProcessor\Tests\Definitions;

use ParamProcessor\Options;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class NumericParamTest extends ParamDefinitionTest {

	public function lowerBoundProvider() {
		return array(
			array( 42, 42, true ),
			array( 42, 41, false ),
			array( 42, 43, true ),
			array( false, 43, true ),
			array( false, 0, true ),
			array( false, -100, true ),
			array( -100, -100, true ),
			array( -99, -100, false ),
			array( -101, -100, true ),
		);
	}

	/**
	 * @dataProvider lowerBoundProvider
	 */
	public function testSetLowerBound( $bound, $testValue, $validity ) {
		$definition = $this->getEmptyInstance();
		$definition->setArrayValues( array( 'lowerbound' => $bound ) );

		$this->validate( $definition, (string)$testValue, $validity );

		$options = new Options();
		$options->setRawStringInputs( false );
		$this->validate( $definition, $testValue, $validity, $options );
	}

	public function upperBoundProvider() {
		return array(
			array( 42, 42, true ),
			array( 42, 41, true ),
			array( 42, 43, false ),
			array( false, 43, true ),
			array( false, 0, true ),
			array( false, -100, true ),
			array( -100, -100, true ),
			array( -99, -100, true ),
			array( -101, -100, false ),
		);
	}

	/**
	 * @dataProvider upperBoundProvider
	 */
	public function testSetUpperBound( $bound, $testValue, $validity ) {
		$definition = $this->getEmptyInstance();
		$definition->setArrayValues( array( 'upperbound' => $bound ) );

		$this->validate( $definition, (string)$testValue, $validity );

		$options = new Options();
		$options->setRawStringInputs( false );
		$this->validate( $definition, $testValue, $validity, $options );
	}

}
