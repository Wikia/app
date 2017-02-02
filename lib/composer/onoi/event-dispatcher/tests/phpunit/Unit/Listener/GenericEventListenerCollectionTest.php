<?php

namespace Onoi\EventDispatcher\Tests\Listener;

use Onoi\EventDispatcher\Listener\GenericEventListenerCollection;
use Onoi\EventDispatcher\Listener\GenericCallbackEventListener;

/**
 * @covers \Onoi\EventDispatcher\Listener\GenericEventListenerCollection
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericEventListenerCollectionTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventListenerCollection',
			new GenericEventListenerCollection()
		);

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericEventListenerCollection',
			new GenericEventListenerCollection()
		);
	}

	public function testRegisterListener() {

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new GenericEventListenerCollection();
		$instance->registerListener( 'FOO', $eventListener );

		$expected = array(
			'foo' => array( $eventListener )
		);

		$this->assertEquals(
			$expected,
			$instance->getCollection()
		);
	}

	public function testTryRegisterListenerUsingInvalidEventIdentifierThrowsException() {

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new GenericEventListenerCollection();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->registerListener( new \stdClass, $eventListener );
	}

	public function testRegisterCallback() {

		$callback = function() { return 'doSomething'; };

		$instance = new GenericEventListenerCollection();
		$instance->registerCallback( 'fOo', $callback );

		$expected = array(
			'foo' => array( new GenericCallbackEventListener( $callback ) )
		);

		$this->assertEquals(
			$expected,
			$instance->getCollection()
		);
	}

	public function testTryRegisterCallbackUsingInvalidEventIdentifierThrowsException() {

		$callback = function() { return 'doSomething'; };

		$instance = new GenericEventListenerCollection();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->registerCallback( new \stdClass, $callback );
	}

	public function testTryRegisterCallbackUsingInvalidCallbackThrowsException() {

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new GenericEventListenerCollection();

		$this->setExpectedException( 'RuntimeException' );
		$instance->registerCallback( 'foo', new \stdClass );
	}

}
