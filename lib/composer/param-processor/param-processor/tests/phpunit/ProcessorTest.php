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
		$options = [];

		$option = new Options();

		$options[] = clone $option;

		$option->setName( 'foobar' );
		$option->setLowercaseNames( false );

		$options[] = clone $option;

		return $this->arrayWrap( $options );
	}

	private function arrayWrap( array $elements ) {
		return array_map(
			function( $element ) {
				return [ $element ];
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
	private function getSimpleParams() {
		$params = [
			'awesome' => 'yes',
			'Howmuch ' => '9001',
			'FLOAT' => '4.2',
			' page' => 'Ohi there!',
			' text     ' => 'foo bar baz o_O',
		];

		$definitions = [
			'awesome' => [
				'type' => 'boolean',
			],
			'howmuch' => [
				'type' => 'integer',
			],
			'float' => [
				'type' => 'float',
			],
			'page' => [
				'type' => 'string',
				'hastoexist' => false,
			],
			'text' => [],
		];

		$options = new Options();

		$expected = [
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 4.2,
			'page' => 'Ohi there!',
			'text' => 'foo bar baz o_O',
		];

		return [ $params, $definitions, $options, $expected ];
	}

	/**
	 * Simple parameter definitions with defaults and values
	 * that are invalid or missing and therefore default.
	 *
	 * @return array
	 */
	private function getDefaultingParams() {
		$params = [
			'awesome' => 'omg!',
			'howmuch' => 'omg!',
			'float' => 'omg!',
			'page' => 42,
			'whot?' => 'O_o',
			'integerr' => ' 9001 ',
		];

		$definitions = [
			'awesome' => [
				'type' => 'boolean',
				'default' => true,
			],
			'howmuch' => [
				'type' => 'integer',
				'default' => 9001,
			],
			'float' => [
				'type' => 'float',
				'default' => 4.2,
			],
			'page' => [
				'type' => 'string',
				'hastoexist' => false,
				'default' => 'Ohi there!',
			],
			'text' => [
				'default' => 'foo bar baz o_O',
			],
			'integerr' => [
				'type' => 'integer',
				'default' => 42,
			],
		];

		$options = new Options();
		$options->setTrimValues( false );

		$expected = [
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 4.2,
			'page' => 'Ohi there!',
			'text' => 'foo bar baz o_O',
			'integerr' => 42,
		];

		return [ $params, $definitions, $options, $expected ];
	}

	/**
	 * Values and definitions in-system parameter handling.
	 * Options set to expect non-raw values.
	 *
	 * @return array
	 */
	private function getTypedParams() {
		$params = [
			'awesome' => true,
			'howmuch' => '42',
			'float' => 4.2,
			'page' => 'Ohi there!',
			'Text' => 'foo bar baz o_O',
			'text1 ' => 'foo bar baz o_O',
			' text2' => 'foo bar baz o_O',
		];

		$definitions = [
			'awesome' => [
				'type' => 'boolean',
			],
			'howmuch' => [
				'type' => 'integer',
				'default' => 9001,
			],
			'float' => [
				'type' => 'float',
				'lowerbound' => 9001,
				'default' => 9000.1
			],
			'page' => [
				'type' => 'string',
				'hastoexist' => false,
			],
			'text' => [
				'default' => 'some text',
			],
			'text1' => [
				'default' => 'some text',
			],
			'text2' => [
				'default' => 'some text',
			],
		];

		$options = new Options();
		$options->setRawStringInputs( false );
		$options->setLowercaseNames( false );
		$options->setTrimNames( false );

		$expected = [
			'awesome' => true,
			'howmuch' => 9001,
			'float' => 9000.1,
			'page' => 'Ohi there!',
			'text' => 'some text',
			'text1' => 'some text',
			'text2' => 'some text',
		];

		return [ $params, $definitions, $options, $expected ];
	}

	/**
	 * Values with capitalization and preceding/tailing spaces to test
	 * of the clean options work.
	 *
	 * @return array
	 */
	private function getUncleanParams() {
		$params = [
			'awesome' => ' yes ',
			'text' => ' FOO  bar  ',
			'integerr' => ' 9001 ',
		];

		$definitions = [
			'awesome' => [
				'type' => 'boolean',
			],
			'text' => [
				'default' => 'bar',
			],
			'integerr' => [
				'type' => 'integer',
				'default' => 42,
			],
		];

		$options = new Options();
		$options->setLowercaseValues( true );
		$options->setTrimValues( true );

		$expected = [
			'awesome' => true,
			'text' => 'foo  bar',
			'integerr' => 9001,
		];

		return [ $params, $definitions, $options, $expected ];
	}

	/**
	 * List parameters to test if list handling works correctly.
	 *
	 * @return array
	 */
	private function getListParams() {
		$params = [
			'awesome' => ' yes, no, on, off ',
			'float' => ' 9001 ; 42 ; 4.2;0',
		];

		$definitions = [
			'awesome' => [
				'type' => 'boolean',
				'islist' => true,
			],
			'text' => [
				'default' => [ 'bar' ],
				'islist' => true,
			],
			'float' => [
				'type' => 'float',
				'islist' => true,
				'delimiter' => ';'
			],
		];

		$options = new Options();
		$options->setLowercaseValues( true );
		$options->setTrimValues( true );

		$expected = [
			'awesome' => [ true, false, true, false ],
			'text' => [ 'bar' ],
			'float' => [ 9001.0, 42.0, 4.2, 0.0 ],
		];

		return [ $params, $definitions, $options, $expected ];
	}

	public function parameterProvider() {
		// $params, $definitions [, $options]
		$argLists = [];

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
	public function testSetParameters( array $params, array $definitions, Options $options ) {
		$validator = Processor::newFromOptions( $options );

		$validator->setParameters( $params, $definitions );

		$this->assertTrue( true ); // TODO
	}

	/**
	 * @dataProvider parameterProvider
	 */
	public function testValidateParameters( array $params, array $definitions, Options $options, array $expected = [] ) {
		$validator = Processor::newFromOptions( $options );

		$validator->setParameters( $params, $definitions );

		$processingResult = $validator->processParameters();

		$actualValues = [];

		foreach ( $processingResult->getParameters() as $param ) {
			$actualValues[$param->getName()] = $param->getValue();
		}

		$this->assertEquals( $expected, $actualValues );


	}

	public function testProcessParametersOnEmptyOptions() {

		$options = new Options();
		$validator = Processor::newFromOptions( $options );

		$this->assertInstanceOf(
			'\ParamProcessor\ProcessingResult',
			$validator->processParameters()
		);
	}

}
