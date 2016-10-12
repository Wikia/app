<?php

namespace Validator\Test;

/**
 * Unit test for the BoolParam class.
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
			'values' => array(
				array( '1', true, true ),
				array( 'yes', true, true ),
				array( 'no', false ),
				array( 'foobar', false ),
			),
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
