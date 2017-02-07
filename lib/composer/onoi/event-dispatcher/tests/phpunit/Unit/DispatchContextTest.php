<?php

namespace Onoi\EventDispatcher\Tests;

use Onoi\EventDispatcher\DispatchContext;

/**
 * @covers \Onoi\EventDispatcher\DispatchContext
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class DispatchContextTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\DispatchContext',
			new DispatchContext()
		);
	}

	public function testRoundtrip() {

		$instance = new DispatchContext();

		$this->assertFalse(
			$instance->has( 'FOO' )
		);

		$instance->set( 'foo', 'bar' );

		$this->assertTrue(
			$instance->has( 'FOO' )
		);

		$this->assertEquals(
			'bar',
			$instance->get( 'FOO' )
		);

		$instance->set( 'foo', new \stdClass );

		$this->assertEquals(
			new \stdClass,
			$instance->get( 'FOO' )
		);
	}

	public function testChangePropagationState() {

		$instance = new DispatchContext();

		$this->assertFalse(
			$instance->isPropagationStopped()
		);

		$instance->set( 'proPagationSTOP', true );

		$this->assertTrue(
			$instance->isPropagationStopped()
		);
	}

	public function testUnknownKeyThrowsException() {

		$instance = new DispatchContext();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->get( 'FOO' );
	}

}
