<?php

namespace Validator\Test;

/**
 * Unit test for the TitleParam class.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @since 0.5
 *
 * @ingroup Validator
 * @ingroup Test
 *
 * @group Validator
 * @group ParamDefinition
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
		$params['values-empty']['values'][] = 'Foo';

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
			'empty-empty' => array(
				array( 'foo bar page', true, \Title::newFromText( 'foo bar page' ) ),
				array( '|', false ),
				array( '', false ),
			),
			'empty' => array(
				array( 'foo bar page', false ),
				array( '|', false ),
				array( '', false ),
			),
			'values-empty' => array(
				array( 'foo', true, \Title::newFromText( 'foo' ) ),
				array( 'foo bar page', false ),
			),
			'values' => array(
				array( 'foo', false ),
				array( 'foo bar page', false ),
			),
		);

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
