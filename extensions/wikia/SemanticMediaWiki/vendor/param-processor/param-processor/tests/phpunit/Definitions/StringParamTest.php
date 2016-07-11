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
		return array(
			'empty' => array(
				array( 'ohi there', true, 'ohi there' ),
				array( 4.2, false ),
				array( array( 42 ), false ),
			),
			'values' => array(
				array( 'foo', true, 'foo' ),
				array( '1', true, '1' ),
				array( 'yes', true, 'yes' ),
				array( 'bar', false ),
				array( true, false ),
				array( 0.1, false ),
				array( array(), false ),
			),
		);
	}

	/**
	 * @see ParamDefinitionTest::getType
	 * @return string
	 */
	public function getType() {
		return 'string';
	}

}
