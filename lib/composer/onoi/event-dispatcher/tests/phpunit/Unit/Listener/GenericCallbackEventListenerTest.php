<?php

namespace Onoi\EventDispatcher\Tests\Listener;

use Onoi\EventDispatcher\Listener\GenericCallbackEventListener;

/**
 * @covers \Onoi\EventDispatcher\Listener\GenericCallbackEventListener
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericCallbackEventListenerTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventListener',
			new GenericCallbackEventListener()
		);

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericCallbackEventListener',
			new GenericCallbackEventListener()
		);
	}

	public function testTryRegisterNonCallbackThrowsException() {

		$instance = new GenericCallbackEventListener();

		$this->setExpectedException( 'RuntimeException' );
		$instance->registerCallback( 'foo' );
	}

	public function testRegisterClosure() {

		$instance = new GenericCallbackEventListener();

		$testClass = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( 'runTest' ) )
			->getMock();

		$testClass->expects( $this->once() )
			->method( 'runTest' );

		$callback = function() use( $testClass ) {
			$testClass->runTest();
		};

		$instance->registerCallback( $callback );
		$instance->execute();
	}

	public function testRegisterClosureViaConstrutor() {

		$testClass = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( 'runTest' ) )
			->getMock();

		$testClass->expects( $this->once() )
			->method( 'runTest' );

		$callback = function() use( $testClass ) {
			$testClass->runTest();
		};

		$instance = new GenericCallbackEventListener( $callback );
		$instance->execute();
	}

	public function testRegisterExecutableCallbackViaConstrutor() {

		$mockTester = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( 'runTest' ) )
			->getMock();

		$mockTester->expects( $this->once() )
			->method( 'runTest' );

		$instance = new GenericCallbackEventListener( array(
			new FooMockTester( $mockTester ), 'invokedCallback' )
		);

		$instance->execute();
	}

	public function testPropagationState() {

		$instance = new GenericCallbackEventListener();

		$this->assertFalse(
			$instance->isPropagationStopped()
		);

		$instance->setPropagationStopState( true );

		$this->assertTrue(
			$instance->isPropagationStopped()
		);
	}

}

class FooMockTester {

	private $mockTester;

	public function __construct( $mockTester ) {
		$this->mockTester = $mockTester;
	}

	public function invokedCallback() {
		$this->mockTester->runTest();
	}

}
