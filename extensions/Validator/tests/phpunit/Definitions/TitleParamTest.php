<?php

namespace ParamProcessor\Tests\Definitions;

/**
 * @group Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TitleParamTest extends ParamDefinitionTest {

	/**
	 * @see ParamDefinitionTest::getDefinitions
	 */
	public function getDefinitions() {
		$params = parent::getDefinitions();

		$params['empty-empty'] = $params['empty'];
		$params['empty-empty']['hastoexist'] = false;

		$params['values-empty'] = $params['values'];
		$params['values-empty']['hastoexist'] = false;
		$params['values-empty']['values'][] = \Title::newFromText( 'foo' );

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
			'empty-empty' => [
				[ 'foo bar page', true, \Title::newFromText( 'foo bar page' ) ],
				[ '|', false ],
				[ '', false ],
			],
			'empty' => [
				[ 'foo bar page', false ],
				[ '|', false ],
				[ '', false ],
			],
			'values-empty' => [
				[ 'foo', true, \Title::newFromText( 'foo' ) ],
				[ 'foo bar page', false ],
			],
			'values' => [
				[ 'foo', false ],
				[ 'foo bar page', false ],
			],
		];

		if ( !$stringlyTyped ) {
			foreach ( $values as &$set ) {
				foreach ( $set as &$value ) {
					$value[0] = \Title::newFromText( $value[0] );
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
		return 'title';
	}

}
