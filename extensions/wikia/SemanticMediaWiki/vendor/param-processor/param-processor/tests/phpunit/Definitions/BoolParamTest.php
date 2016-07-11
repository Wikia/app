<?php

namespace ParamProcessor\Tests\Definitions;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BoolParamTest extends ParamDefinitionTest {

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
				array( 'yes', true, true ),
				array( 'on', true, true ),
				array( '1', true, true ),
				array( 'no', true, false ),
				array( 'off', true, false ),
				array( '0', true, false ),
				array( 'foobar', false ),
				array( '2', false ),
				array( array(), false ),
				array( 42, false ),
			),
			'values' => array(),
//			'values' => array(
//				array( '1', true, true ),
//				array( 'yes', true, true ),
//				array( 'no', false ),
//				array( 'foobar', false ),
//			),
		);

		if ( !$stringlyTyped ) {
			foreach ( $values as &$set ) {
				foreach ( $set as &$value ) {
					if ( in_array( $value[0], array( 'yes', 'on', '1', '0', 'off', 'no' ), true ) ) {
						$value[0] = in_array( $value[0], array( 'yes', 'on', '1' ), true );
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
		return 'boolean';
	}

}
