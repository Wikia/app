<?php

namespace Validator\Test;
use Validator, ValidatorOptions;

/**
 * Unit test for the Validator class.
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
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValidatorTest extends \MediaWikiTestCase {

	public function testConstructor() {
		$this->assertInstanceOf( '\Validator', new Validator() );
	}

	public function newFromOptionsProvider() {
		$options = array();

		$option = new ValidatorOptions();

		$options[] = clone $option;

		$option->setName( 'foobar' );
		$option->setLowercaseNames( false );

		$options[] = clone $option;

		return $this->arrayWrap( $options );
	}

	protected function arrayWrap( array $elements ) {
		return array_map(
			function( $element ) {
				return array( $element );
			},
			$elements
		);
	}

	public function testNewFromOptions() {
		$options = new ValidatorOptions();
		$validator = Validator::newFromOptions( clone $options );
		$this->assertInstanceOf( '\Validator', $validator );
		$this->assertEquals( $options, $validator->getOptions() );
	}

	/**
	 * Simple parameter definitions and values that should all pass.
	 *
	 * @return array
	 */
	protected function getSimpleParams() {
		$params = array(
			'awesome' => 'yes',
			'Howmuch ' => '9001',
			'FLOAT' => '4.2',
			' page' => 'Ohi there!',
			' text     ' => 'foo bar baz o_O',
		);

		$definitions = array(
			'awesome' => array(
				'type' => 'boolean',
			),
			'howmuch' => array(
				'type' => 'integer',
			),
			'float' => array(
				'type' => 'float',
			),
			'page' => array(
				'type' => 'title',
				'hastoexist' => false,
			),
			'text' => array(),
		);

		$options = new ValidatorOptions();

		$expected = array(
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 4.2,
			'page' => \Title::newFromText( 'Ohi there!' ),
			'text' => 'foo bar baz o_O',
		);

		return array( $params, $definitions, $options, $expected );
	}

	/**
	 * Simple parameter definitions with defaults and values
	 * that are invalid or missing and therefore default.
	 *
	 * @return array
	 */
	protected function getDefaultingParams() {
		$params = array(
			'awesome' => 'omg!',
			'howmuch' => 'omg!',
			'float' => 'omg!',
			'page' => '|',
			'whot?' => 'O_o',
			'integerr' => ' 9001 ',
		);

		$definitions = array(
			'awesome' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'howmuch' => array(
				'type' => 'integer',
				'default' => 9001,
			),
			'float' => array(
				'type' => 'float',
				'default' => 4.2,
			),
			'page' => array(
				'type' => 'title',
				'hastoexist' => false,
				'default' => \Title::newFromText( 'Ohi there!' ),
			),
			'text' => array(
				'default' => 'foo bar baz o_O',
			),
			'integerr' => array(
				'type' => 'integer',
				'default' => 42,
			),
		);

		$options = new ValidatorOptions();
		$options->setTrimValues( false );

		$expected = array(
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 4.2,
			'page' => \Title::newFromText( 'Ohi there!' ),
			'text' => 'foo bar baz o_O',
			'integerr' => 42,
		);

		return array( $params, $definitions, $options, $expected );
	}

	/**
	 * Values and definitions in-system parameter handling.
	 * Options set to expect non-raw values.
	 *
	 * @return array
	 */
	protected function getTypedParams() {
		$params = array(
			'awesome' => true,
			'howmuch' => '42',
			'float' => 4.2,
			'page' => \Title::newFromText( 'Ohi there!' ),
			'Text' => 'foo bar baz o_O',
			'text1 ' => 'foo bar baz o_O',
			' text2' => 'foo bar baz o_O',
		);

		$definitions = array(
			'awesome' => array(
				'type' => 'boolean',
			),
			'howmuch' => array(
				'type' => 'integer',
				'default' => 9001,
			),
			'float' => array(
				'type' => 'float',
				'lowerbound' => 9001,
				'default' => 9000.1
			),
			'page' => array(
				'type' => 'title',
				'hastoexist' => false,
			),
			'text' => array(
				'default' => 'some text',
			),
			'text1' => array(
				'default' => 'some text',
			),
			'text2' => array(
				'default' => 'some text',
			),
		);

		$options = new ValidatorOptions();
		$options->setRawStringInputs( false );
		$options->setLowercaseNames( false );
		$options->setTrimNames( false );

		$expected = array(
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 9000.1,
			'page' => \Title::newFromText( 'Ohi there!' ),
			'text' => 'some text',
			'text1' => 'some text',
			'text2' => 'some text',
		);

		return array( $params, $definitions, $options, $expected );
	}

	/**
	 * Values with capitalization and preceding/tailing spaces to test
	 * of the clean options work.
	 *
	 * @return array
	 */
	protected function getUncleanParams() {
		$params = array(
			'awesome' => ' yes ',
			'text' => ' FOO  bar  ',
			'integerr' => ' 9001 ',
		);

		$definitions = array(
			'awesome' => array(
				'type' => 'boolean',
			),
			'text' => array(
				'default' => 'bar',
			),
			'integerr' => array(
				'type' => 'integer',
				'default' => 42,
			),
		);

		$options = new ValidatorOptions();
		$options->setLowercaseValues( true );
		$options->setTrimValues( true );

		$expected = array(
			'awesome' => true,
			'text' => 'foo  bar',
			'integerr' => 9001,
		);

		return array( $params, $definitions, $options, $expected );
	}

	public function parameterProvider() {
		// $params, $definitions [, $options, $expected]
		$argLists = array();

		$argLists[] = $this->getSimpleParams();

		$argLists[] = $this->getDefaultingParams();

		$argLists[] = $this->getTypedParams();

		$argLists[] = $this->getUncleanParams();

		foreach ( $argLists as &$argList ) {
			foreach ( $argList[1] as $key => &$definition ) {
				$definition['message'] = 'test-' . $key;
			}

			if ( !array_key_exists( 2, $argList ) ) {
				$argList[2] = new ValidatorOptions();
			}
		}

		return $argLists;
	}

	/**
	 * @dataProvider parameterProvider
	 */
	public function testSetParameters( array $params, array $definitions, ValidatorOptions $options, array $expected = array() ) {
		$validator = Validator::newFromOptions( $options );

		$validator->setParameters( $params, $definitions );

		$this->assertTrue( true ); // TODO
	}

	/**
	 * @dataProvider parameterProvider
	 */
	public function testValidateParameters( array $params, array $definitions, ValidatorOptions $options, array $expected = array() ) {
		$validator = Validator::newFromOptions( $options );

		$validator->setParameters( $params, $definitions );

		$validator->validateParameters();

		$this->assertArrayEquals( $expected, $validator->getParameterValues(), false, true );
	}

}
