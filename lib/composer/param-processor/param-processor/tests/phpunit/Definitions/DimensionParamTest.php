<?php

namespace ParamProcessor\Tests\Definitions;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DimensionParamTest extends ParamDefinitionTest {

	/**
	 * @see ParamDefinitionTest::getDefinitions
	 * @return array
	 */
	public function getDefinitions() {
		$params = parent::getDefinitions();

		$params['auto'] = [
			'allowauto' => true,
		];

		$params['allunits'] = [
			'units' => [ 'px', 'ex', 'em', '%', '' ],
		];

		$params['bounds'] = [
			'lowerbound' => 42,
			'upperbound' => 9000,
			'maxpercentage' => 34,
			'minpercentage' => 23,
			'units' => [ 'px', 'ex', '%', '' ],
		];

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
				[ '100px', true, '100px' ],
				[ '100', true, '100px' ],
				[ 42, true, '42px' ],
				[ 42.5, true, '42.5px' ],
				[ 'over9000', false ],
				[ 'yes', false ],
				[ 'auto', false ],
				[ '100%', false ],
			],
			'values' => [
				[ 1, true, '1px' ],
//				array( 2, false ),
				[ 'yes', false ],
				[ 'no', false ],
			],
			'auto' => [
				[ 'auto', true, 'auto' ],
			],
			'allunits' => [
				[ '100%', true, '100%' ],
				[ '100em', true, '100em' ],
				[ '100ex', true, '100ex' ],
				[ '101%', false ],
			],
			'bounds' => [
				[ '30%', true, '30%' ],
				[ '20%', false ],
				[ '40%', false ],
				[ '100px', true, '100px' ],
				[ '100ex', true, '100ex' ],
				[ '10px', false ],
				[ '9001ex', false ],
			],
		];

		if ( $stringlyTyped ) {
			foreach ( $values as &$set ) {
				foreach ( $set as &$value ) {
					if ( is_int( $value[0] ) || is_float( $value[0] ) ) {
						$value[0] = (string)$value[0];
					}
				}
			}

//			$values['empty'][] = array( 42, false );
//			$values['empty'][] = array( 42.5, false );
		}

		return $values;
	}

	/**
	 * @see ParamDefinitionTest::getType
	 * @return string
	 */
	public function getType() {
		return 'dimension';
	}

}
