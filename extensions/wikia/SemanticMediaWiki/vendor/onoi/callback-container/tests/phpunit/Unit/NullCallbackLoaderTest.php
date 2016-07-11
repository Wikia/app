<?php

namespace Onoi\CallbackContainer\Tests;

use Onoi\CallbackContainer\NullCallbackLoader;

/**
 * @covers \Onoi\CallbackContainer\NullCallbackLoader
 * @group onoi-callback-container
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullCallbackLoaderTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\CallbackContainer\NullCallbackLoader',
			new NullCallbackLoader()
		);
	}

	public function testInterfaceMethods() {

		$instance = new NullCallbackLoader();

		$this->assertNull(
			$instance->load( 'Foo' )
		);

		$this->assertNull(
			$instance->singleton( 'Foo' )
		);

		$this->assertNull(
			$instance->registerExpectedReturnType( 'Foo', 'bar' )
		);

		$this->assertNull(
			$instance->registerCallback( 'Foo', function() {} )
		);
	}

}
