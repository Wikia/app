<?php

namespace Validator\Test;

/**
 * Unit test for the FloatParam class.
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
				array( 1, true, 1 ),
				array( 1.1, true, 1.1 ),
				array( 0.2555, true, 0.2555 ),
				array( '1.1.1', false ),
				array( 'foobar', false ),
				array( array(), false ),
				array( 'yes', false ),
				array( false, false ),
			),
			'values' => array(
				array( 1, true, 1 ),
				array( 'yes', false ),
				array( 'no', false ),
				array( 0.1, true, 0.1 ),
				array( 0.2555, false ),
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
		return 'float';
	}

}
