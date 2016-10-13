<?php

namespace Validator\Test;
use ValidatorOptions;

/**
 * Unit test for the Validator\Options class.
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
 * @group ValidatorOptions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValidatorOptionsTest extends \MediaWikiTestCase {

	public function testConstructor() {
		$this->assertInstanceOf( '\ValidatorOptions', new ValidatorOptions() );
	}

	/**
	 * @return \ValidatorOptions
	 */
	protected function getInstance() {
		return new ValidatorOptions();
	}

	public function testBooleanSettersAndGetters() {
		$methods = array(
			'setUnknownInvalid' => 'unknownIsInvalid',
			'setLowercaseNames' => 'lowercaseNames',
			'setRawStringInputs' => 'isStringlyTyped',
			'setTrimNames' => 'trimNames',
			'setTrimValues' => 'trimValues',
			'setLowercaseValues' => 'lowercaseValues',
		);

		foreach ( $methods as $setter => $getter ) {
			$options = $this->getInstance();

			foreach ( array( false, true, false ) as $boolean ) {
				call_user_func_array( array( $options, $setter ), array( $boolean ) );

				$this->assertEquals( $boolean, call_user_func( array( $options, $getter ) ) );
			}
		}
	}

	public function testSetAndGetName() {
		$options = $this->getInstance();

		foreach ( array( 'foo', 'bar baz' ) as $name ) {
			$options->setName( $name );
			$this->assertEquals( $name, $options->getName() );
		}
	}

}
