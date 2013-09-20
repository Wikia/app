<?php

namespace Validator\Test;

/**
 * Unit test for the DimensionParam class.
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
class DimensionParamTest extends ParamDefinitionTest {

	/**
	 * @see ParamDefinitionTest::getDefinitions
	 * @return array
	 */
	public function getDefinitions() {
		$params = parent::getDefinitions();

		$params['auto'] = array(
			'allowauto' => true,
		);

		$params['allunits'] = array(
			'units' => array( 'px', 'ex', 'em', '%', '' ),
		);

		$params['bounds'] = array(
			'lowerbound' => 42,
			'upperbound' => 9000,
			'maxpercentage' => 34,
			'minpercentage' => 23,
			'units' => array( 'px', 'ex', '%', '' ),
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
			'empty' => array(
				array( '100px', true, '100px' ),
				array( '100', true, '100px' ),
				array( 42, true, '42px' ),
				array( 42.5, true, '42.5px' ),
				array( 'over9000', false ),
				array( 'yes', false ),
				array( 'auto', false ),
				array( '100%', false ),
			),
			'values' => array(
				array( 1, true, '1px' ),
				array( 2, false ),
				array( 'yes', false ),
				array( 'no', false ),
			),
			'auto' => array(
				array( 'auto', true, 'auto' ),
			),
			'allunits' => array(
				array( '100%', true, '100%' ),
				array( '100em', true, '100em' ),
				array( '100ex', true, '100ex' ),
				array( '101%', false ),
			),
			'bounds' => array(
				array( '30%', true, '30%' ),
				array( '20%', false ),
				array( '40%', false ),
				array( '100px', true, '100px' ),
				array( '100ex', true, '100ex' ),
				array( '10px', false ),
				array( '9001ex', false ),
			),
		);

		if ( $stringlyTyped ) {
			foreach ( $values as &$set ) {
				foreach ( $set as &$value ) {
					if ( is_int( $value[0] ) || is_float( $value[0] ) ) {
						$value[0] = (string)$value[0];
					}
				}
			}

			$values['empty'][] = array( 42, false );
			$values['empty'][] = array( 42.5, false );
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
