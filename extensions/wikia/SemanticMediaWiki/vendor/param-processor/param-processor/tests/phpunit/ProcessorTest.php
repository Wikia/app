<?php

namespace ParamProcessor\Tests;

use ParamProcessor\Processor;
use ParamProcessor\Options;

/**
 * @covers ParamProcessor\Processor
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ProcessorTest extends \PHPUnit_Framework_TestCase {

	public function testNewDefault() {
		$this->assertInstanceOf( 'ParamProcessor\Processor', Processor::newDefault() );
	}

	public function newFromOptionsProvider() {
		$options = array();

		$option = new Options();

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
		$options = new Options();
		$validator = Processor::newFromOptions( clone $options );
		$this->assertInstanceOf( '\ParamProcessor\Processor', $validator );
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
				'type' => 'string',
				'hastoexist' => false,
			),
			'text' => array(),
		);

		$options = new Options();

		$expected = array(
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 4.2,
			'page' => 'Ohi there!',
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
			'page' => 42,
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
				'type' => 'string',
				'hastoexist' => false,
				'default' => 'Ohi there!',
			),
			'text' => array(
				'default' => 'foo bar baz o_O',
			),
			'integerr' => array(
				'type' => 'integer',
				'default' => 42,
			),
		);

		$options = new Options();
		$options->setTrimValues( false );

		$expected = array(
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 4.2,
			'page' => 'Ohi there!',
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
			'page' => 'Ohi there!',
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
				'type' => 'string',
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

		$options = new Options();
		$options->setRawStringInputs( false );
		$options->setLowercaseNames( false );
		$options->setTrimNames( false );

		$expected = array(
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 9000.1,
			'page' => 'Ohi there!',
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

		$options = new Options();
		$options->setLowercaseValues( true );
		$options->setTrimValues( true );

		$expected = array(
			'awesome' => true,
			'text' => 'foo  bar',
			'integerr' => 9001,
		);

		return array( $params, $definitions, $options, $expected );
	}

	/**
	 * List parameters to test if list handling works correctly.
	 *
	 * @return array
	 */
	protected function getListParams() {
		$params = array(
			'awesome' => ' yes, no, on, off ',
			'float' => ' 9001 ; 42 ; 4.2;0',
		);

		$definitions = array(
			'awesome' => array(
				'type' => 'boolean',
				'islist' => true,
			),
			'text' => array(
				'default' => array( 'bar' ),
				'islist' => true,
			),
			'float' => array(
				'type' => 'float',
				'islist' => true,
				'delimiter' => ';'
			),
		);

		$options = new Options();
		$options->setLowercaseValues( true );
		$options->setTrimValues( true );

		$expected = array(
			'awesome' => array( true, false, true, false ),
			'text' => array( 'bar' ),
			'float' => array( 9001.0, 42.0, 4.2, 0.0 ),
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

		$argLists[] = $this->getListParams();

		foreach ( $argLists as &$argList ) {
			foreach ( $argList[1] as $key => &$definition ) {
				$definition['message'] = 'test-' . $key;
			}

			if ( !array_key_exists( 2, $argList ) ) {
				$argList[2] = new Options();
			}
		}

		return $argLists;
	}

	/**
	 * @dataProvider parameterProvider
	 */
	public function testSetParameters( array $params, array $definitions, Options $options, array $expected = array() ) {
		$validator = Processor::newFromOptions( $options );

		$validator->setParameters( $params, $definitions );

		$this->assertTrue( true ); // TODO
	}

	/**
	 * @dataProvider parameterProvider
	 */
	public function testValidateParameters( array $params, array $definitions, Options $options, array $expected = array() ) {
		$validator = Processor::newFromOptions( $options );

		$validator->setParameters( $params, $definitions );

		$processingResult = $validator->processParameters();

		$actualValues = array();

		foreach ( $processingResult->getParameters() as $param ) {
			$actualValues[$param->getName()] = $param->getValue();
		}

		$this->assertEquals( $expected, $actualValues );


	}

}
