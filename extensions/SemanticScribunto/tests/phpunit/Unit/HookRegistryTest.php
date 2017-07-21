<?php

namespace SMW\Scribunto\Tests;

use SMW\Scribunto\HookRegistry;

/**
 * @covers \SMW\Scribunto\HookRegistry
 * @group semantic-scribunto
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class HookRegistryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\SMW\Scribunto\HookRegistry',
			new HookRegistry()
		);
	}

	public function testRegister() {

		$instance = new HookRegistry();
		$instance->register();

		$this->doTestRegisteredScribuntoExternalLibraries( $instance );
	}

	public function doTestRegisteredScribuntoExternalLibraries( $instance ) {

		$handler = 'ScribuntoExternalLibraries';

		$engine = '';
		$extraLibraries = [];

		$this->assertTrue(
			$instance->isRegistered( $handler )
		);

		$this->assertThatHookIsExcutable(
			$instance->getHandlerFor( $handler ),
			[ $engine, &$extraLibraries ]
		);

		$this->assertArrayHasKey(
			'mw.smw',
			$extraLibraries
		);
	}

	private function assertThatHookIsExcutable( \Closure $handler, $arguments ) {
		$this->assertInternalType(
			'boolean',
			call_user_func_array( $handler, $arguments )
		);
	}

}
