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
		$values = [
			'empty' => [
				[ 'yes', true, true ],
				[ 'on', true, true ],
				[ '1', true, true ],
				[ 'no', true, false ],
				[ 'off', true, false ],
				[ '0', true, false ],
				[ 'foobar', false ],
				[ '2', false ],
				[ [], false ],
				[ 42, false ],
			],
			'values' => [],
//			'values' => array(
//				array( '1', true, true ),
//				array( 'yes', true, true ),
//				array( 'no', false ),
//				array( 'foobar', false ),
//			),
		];

		if ( !$stringlyTyped ) {
			foreach ( $values as &$set ) {
				foreach ( $set as &$value ) {
					if ( in_array( $value[0], [ 'yes', 'on', '1', '0', 'off', 'no' ], true ) ) {
						$value[0] = in_array( $value[0], [ 'yes', 'on', '1' ], true );
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
