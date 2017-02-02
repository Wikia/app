<?php

namespace Maps\Test;

use ParamProcessor\ParamDefinition;
use ParamProcessor\Processor;

/**
 * @group Maps
 * @group ParserHook
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ParserHookTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 2.0
	 * @return \ParserHook
	 */
	protected abstract function getInstance();

	/**
	 * @since 2.0
	 * @return array
	 */
	public abstract function parametersProvider();

	/**
	 * Triggers the render process with different sets of parameters to see if
	 * no errors or notices are thrown and the result indeed is a string.
	 *
	 * @dataProvider parametersProvider
	 * @since 2.0
	 * @param array $parameters
	 * @param string|null $expected
	 */
	public function testRender( array $parameters, $expected = null ) {
		$parserHook = $this->getInstance();

		$parser = new \Parser();
		$parser->mOptions = new \ParserOptions();
		$parser->clearState();
		$parser->setTitle( \Title::newMainPage() );

		$renderResult = call_user_func_array(
			array( $parserHook, 'renderFunction' ),
			array_merge( array( &$parser ), $parameters )
		);

		if ( is_string( $renderResult ) ) {
			$this->assertTrue( true );
		}
		else {
			$this->assertInternalType( 'array', $renderResult );
			$this->assertInternalType( 'string', $renderResult[0] );
		}

		if ( $expected !== null ) {
			$this->assertEquals( $expected, $renderResult[0] );
		}
	}

	public function processingProvider() {
		return array();
	}

	/**
	 * @dataProvider processingProvider
	 * @since 3.0
	 */
	public function testParamProcessing( array $parameters, array $expectedValues ) {
		$definitions = $this->getInstance()->getParamDefinitions();

		$processor = Processor::newDefault();
		$processor->setParameters( $parameters, $definitions );

		$result = $processor->processParameters();

		if ( $result->hasFatal() ) {
			$this->fail( 'Fatal error occurred during the param processing: ' . $processor->hasFatalError()->getMessage() );
		}

		$actual = $result->getParameters();

		$expectedValues = array_merge( $this->getDefaultValues(), $expectedValues );

		foreach ( $expectedValues as $name => $expected ) {
			$this->assertArrayHasKey( $name, $actual );

			$this->assertEquals(
				$expected,
				$actual[$name]->getValue(),
				'Expected ' . var_export( $expected, true )
					. ' should match actual '
					. var_export( $actual[$name]->getValue(), true )
			);
		}
	}

	/**
	 * Returns an array with the default values of the parameters.
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	protected function getDefaultValues() {
		$definitions = ParamDefinition::getCleanDefinitions( $this->getInstance()->getParamDefinitions() );

		$defaults = array();

		foreach ( $definitions as $definition ) {
			if ( !$definition->isRequired() ) {
				$defaults[$definition->getName()] = $definition->getDefault();
			}
		}

		return $defaults;
	}

	protected function arrayWrap( array $elements ) {
		return array_map(
			function ( $element ) {
				return array( $element );
			},
			$elements
		);
	}

}