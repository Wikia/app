<?php

namespace Onoi\CallbackContainer\Tests;

use Onoi\CallbackContainer\NullCallbackInstantiator;

/**
 * @covers \Onoi\CallbackContainer\NullCallbackInstantiator
 * @group onoi-callback-container
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class NullCallbackInstantiatorTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\CallbackContainer\NullCallbackInstantiator',
			new NullCallbackInstantiator()
		);
	}

	public function testInterfaceMethods() {

		$instance = new NullCallbackInstantiator();

		$this->assertNull(
			$instance->create( 'Foo' )
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

		$callbackContainer = $this->getMockBuilder( '\Onoi\CallbackContainer\CallbackContainer' )
			->disableOriginalConstructor()
			->getMock();

		$this->assertNull(
			$instance->registerCallbackContainer( $callbackContainer )
		);
	}

}
