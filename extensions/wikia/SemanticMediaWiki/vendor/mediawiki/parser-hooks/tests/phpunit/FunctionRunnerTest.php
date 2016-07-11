<?php

namespace ParserHooks\Tests;

use ParamProcessor\ProcessedParam;
use ParamProcessor\ProcessingResult;
use ParserHooks\FunctionRunner;
use ParserHooks\HookDefinition;

/**
 * @covers ParserHooks\FunctionRunner
 * @covers ParserHooks\Internal\Runner
 *
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunnerTest extends \PHPUnit_Framework_TestCase {

	public function optionsProvider() {
		return array(
			array(
				array(
					FunctionRunner::OPT_DO_PARSE => true,
				),
			),
			array(
				array(
					FunctionRunner::OPT_DO_PARSE => false,
				),
			),
		);
	}

	const HOOK_HANDLER_RESULT = 'hook handler result';

	protected $options;

	protected $parser;

	/**
	 * @dataProvider optionsProvider
	 */
	public function testRun( array $options ) {
		$this->options = $options;

		$definition = new HookDefinition( 'someHook' );

		$this->parser = $this->getMock( 'Parser' );

		$inputParams = array(
			'foo=bar',
			'baz=42',
		);

		$processedParams = new ProcessingResult( array(
			'foo' => new ProcessedParam( 'foo', 'bar', false )
		) );

		$paramProcessor = $this->newMockParamProcessor( $inputParams, $processedParams );

		$hookHandler = $this->newMockHookHandler( $processedParams );

		$runner = new FunctionRunner(
			$definition,
			$hookHandler,
			$this->options,
			$paramProcessor
		);

		$frame = $this->getMock( 'PPFrame' );

		$frame->expects( $this->exactly( count( $inputParams ) ) )
			->method( 'expand' )
			->will( $this->returnArgument( 0 ) );

		$result = $runner->run(
			$this->parser,
			$inputParams,
			$frame
		);

		$this->assertResultIsValid( $result );
	}

	protected function assertResultIsValid( $result ) {
		$expected = array( self::HOOK_HANDLER_RESULT );

		if ( !$this->options[FunctionRunner::OPT_DO_PARSE] ) {
			$expected['noparse'] = true;
			$expected['isHTML'] = true;
		}

		$this->assertEquals( $expected, $result );
	}

	protected function newMockHookHandler( $expectedParameters ) {
		$hookHandler = $this->getMock( 'ParserHooks\HookHandler' );

		$hookHandler->expects( $this->once() )
			->method( 'handle' )
			->with(
				$this->equalTo( $this->parser ),
				$this->equalTo( $expectedParameters )
			)
			->will( $this->returnValue( self::HOOK_HANDLER_RESULT ) );

		return $hookHandler;
	}

	protected function newMockParamProcessor( $expandedParams, $processedParams ) {
		$paramProcessor = $this->getMockBuilder( 'ParamProcessor\Processor' )
			->disableOriginalConstructor()->getMock();

		$paramProcessor->expects( $this->once() )
			->method( 'setFunctionParams' )
			->with( $this->equalTo( $expandedParams ) );

		$paramProcessor->expects( $this->once() )
			->method( 'processParameters' )
			->will( $this->returnValue( $processedParams ) );

		return $paramProcessor;
	}

}
