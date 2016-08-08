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

		$params['count'] = [
			'type' => 'integer',
		];

		$params['amount'] = [
			'type' => 'integer',
			'default' => 42,
			'upperbound' => 99,
		];

		$params['number'] = [
			'type' => 'integer',
			'upperbound' => 99,
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
			'count' => [
				[ 42, true, 42 ],
				[ 'foo', false ],
				[ 4.2, false ],
				[ [ 42 ], false ],
			],
			'amount' => [
				[ 0, true, 0 ],
				[ 'foo', false, 42 ],
				[ 100, false, 42 ],
				[ 4.2, false, 42 ],
			],
			'number' => [
				[ 42, true, 42 ],
				[ 'foo', false ],
				[ 100, false ],
				[ 4.2, false ],
			],
			'empty' => [
				[ 42, true, 42 ],
				[ 4.2, false ],
				[ [ 42 ], false ],
			],
			'values' => [
				[ 1, true, 1 ],
				[ 'yes', false ],
				[ true, false ],
				[ 0.1, false ],
				[ [], false ],
			],
		];

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
