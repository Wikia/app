<?php

namespace ParamProcessor\Tests\Definitions;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FloatParamTest extends NumericParamTest {

	/**
	 * @see ParamDefinitionTest::getDefinitions
	 * @return array
	 */
	public function getDefinitions() {
		$params = parent::getDefinitions();

		return $params;
	}

	/**
	 * @see ParamDefinitionTest::valueProvider
	 *
	 * @param boolean $stringlyTyped
	 *
	 * @return array
	 */
	public function valueProvider( $stringlyTyped = true ) {
		$values = array(
			'empty' => array(
				array( 1, true, 1.0 ),
				array( 1.0, true, 1.0 ),
				array( 1.1, true, 1.1 ),
				array( 0.2555, true, 0.2555 ),
				array( '1.1.1', false ),
				array( 'foobar', false ),
				array( array(), false ),
				array( 'yes', false ),
				array( false, false ),
			),
			'values' => array(),
//			'values' => array(
//				array( 1, true, 1 ),
//				array( 'yes', false ),
//				array( 'no', false ),
//				array( 0.1, true, 0.1 ),
//				array( 0.2555, false ),
//			),
		);

		if ( $stringlyTyped ) {
			foreach ( $values as &$set ) {
				foreach ( $set as &$value ) {
					if ( is_float( $value[0] ) || is_int( $value[0] ) ) {
						$value[0] = (string)$value[0];
					}
				}
			}
		}

		return $values;
	}

	/**
	 * @see ParamDefinitionTest::getType
	 * @return string
	 */
	public function getType() {
		return 'float';
	}

}
