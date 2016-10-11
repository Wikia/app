<?php

namespace ParserHooks\Tests;

use ParserHooks\HookDefinition;
use ParserHooks\HookRegistrant;

/**
 * @covers ParserHooks\HookRegistrant
 *
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookRegistrantTest extends \PHPUnit_Framework_TestCase {

	public function namesProvider() {
		return array(
			array( array( 'foo' ) ),
			array( array( 'foo', 'bar' ) ),
			array( array( 'foo', 'bar', 'baz', 'bah' ) ),
		);
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterFunction( array $names ) {
		$parser = $this->newMockParserForFunction( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerFunction( $this->newMockRunner( $names, 'ParserHooks\FunctionRunner' ) );
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterHook( array $names ) {
		$parser = $this->newMockParserForHook( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerHook( $this->newMockRunner( $names, 'ParserHooks\HookRunner' ) );
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterFunctionHandler( array $names ) {
		$parser = $this->newMockParserForFunction( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerFunctionHandler(
			new HookDefinition( $names ),
			$this->getMock( 'ParserHooks\HookHandler' )
		);
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterHookHandler( array $names ) {
		$parser = $this->newMockParserForHook( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerHookHandler(
			new HookDefinition( $names ),
			$this->getMock( 'ParserHooks\HookHandler' )
		);
	}

	protected function newMockParserForFunction( array $names ) {
		return $this->newMockParser( $names, 'setFunctionHook' );
	}

	protected function newMockParserForHook( array $names ) {
		return $this->newMockParser( $names, 'setHook' );
	}

	protected function newMockParser( array $names, $expectedMethod ) {
		$parser = $this->getMock( 'Parser' );

		foreach ( $names as $index => $name ) {
			$parser->expects( $this->at( $index ) )
				->method( $expectedMethod )
				->with(
					$this->equalTo( $name ),
					$this->isType( 'callable' )
				);
		}

		return $parser;
	}

	protected function newMockRunner( array $names, $runnerClass ) {
		$definition = new HookDefinition( $names );

		$runner = $this->getMockBuilder( $runnerClass )
			->disableOriginalConstructor()->getMock();

		$runner->expects( $this->once() )
			->method( 'getDefinition' )
			->will( $this->returnValue( $definition ) );

		return $runner;
	}

}
