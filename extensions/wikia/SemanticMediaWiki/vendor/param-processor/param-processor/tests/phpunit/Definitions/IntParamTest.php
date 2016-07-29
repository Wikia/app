<?php

namespace ParamProcessor\Tests\Definitions;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class IntParamTest extends NumericParamTest {

	/**
	 * @see ParamDefinitionTest::getDefinitions
	 * @return array
	 */
	public function getDefinitions() {
		$params = parent::getDefinitions();

		$params['count'] = array(
			'type' => 'integer',
		);

		$params['amount'] = array(
			'type' => 'integer',
			'default' => 42,
			'upperbound' => 99,
		);

		$params['number'] = array(
			'type' => 'integer',
			'upperbound' => 99,
		);

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
			'count' => array(
				array( 42, true, 42 ),
				array( 'foo', false ),
				array( 4.2, false ),
				array( array( 42 ), false ),
			),
			'amount' => array(
				array( 0, true, 0 ),
				array( 'foo', false, 42 ),
				array( 100, false, 42 ),
				array( 4.2, false, 42 ),
			),
			'number' => array(
				array( 42, true, 42 ),
				array( 'foo', false ),
				array( 100, false ),
				array( 4.2, false ),
			),
			'empty' => array(
				array( 42, true, 42 ),
				array( 4.2, false ),
				array( array( 42 ), false ),
			),
			'values' => array(
				array( 1, true, 1 ),
				array( 'yes', false ),
				array( true, false ),
				array( 0.1, false ),
				array( array(), false ),
			),
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
		return 'integer';
	}

}
