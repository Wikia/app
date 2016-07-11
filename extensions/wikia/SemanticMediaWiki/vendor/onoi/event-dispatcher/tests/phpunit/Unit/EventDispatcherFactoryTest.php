<?php

namespace Onoi\EventDispatcher\Tests;

use Onoi\EventDispatcher\EventDispatcherFactory;

/**
 * @covers \Onoi\EventDispatcher\EventDispatcherFactory
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventDispatcherFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventDispatcherFactory',
			$instance
		);

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventDispatcherFactory',
			EventDispatcherFactory::getInstance()
		);

		EventDispatcherFactory::clear();
	}

	public function testCanConstructDispatchContext() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\DispatchContext',
			$instance->newDispatchContext()
		);
	}

	public function testCanConstructGenericEventDispatcher() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher',
			$instance->newGenericEventDispatcher()
		);
	}

	public function testCanConstructNullEventListener() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\NullEventListener',
			$instance->newNullEventListener()
		);
	}

	public function testCanConstructGenericCallbackEventListener() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericCallbackEventListener',
			$instance->newGenericCallbackEventListener()
		);
	}

	public function testCanConstructGenericEventListenerCollection() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericEventListenerCollection',
			$instance->newGenericEventListenerCollection()
		);
	}

}
