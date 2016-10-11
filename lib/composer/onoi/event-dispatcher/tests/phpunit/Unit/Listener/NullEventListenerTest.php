<?php

namespace Onoi\EventDispatcher\Tests\Listener;

use Onoi\EventDispatcher\Listener\NullEventListener;

/**
 * @covers \Onoi\EventDispatcher\Listener\NullEventListener
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullEventListenerTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventListener',
			new NullEventListener()
		);

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\NullEventListener',
			new NullEventListener()
		);
	}

	public function testExecute() {

		$instance = new NullEventListener();

		$this->assertNull(
			$instance->execute()
		);
	}

	public function testIsPropagationStopped() {

		$instance = new NullEventListener();

		$this->assertFalse(
			$instance->isPropagationStopped()
		);
	}

}
