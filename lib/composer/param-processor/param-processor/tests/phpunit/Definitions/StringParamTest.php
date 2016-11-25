<?php

namespace ParamProcessor\Tests\Definitions;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StringParamTest extends ParamDefinitionTest {

	/**
	 * @see ParamDefinitionTest::getDefinitions
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
		return [
			'empty' => [
				[ 'ohi there', true, 'ohi there' ],
				[ 4.2, false ],
				[ [ 42 ], false ],
			],
			'values' => [
				[ 'foo', true, 'foo' ],
				[ '1', true, '1' ],
				[ 'yes', true, 'yes' ],
				[ 'bar', false ],
				[ true, false ],
				[ 0.1, false ],
				[ [], false ],
			],
		];
	}

	/**
	 * @see ParamDefinitionTest::getType
	 * @return string
	 */
	public function getType() {
		return 'string';
	}

}
