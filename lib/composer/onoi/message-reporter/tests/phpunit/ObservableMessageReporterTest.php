<?php

namespace Onoi\MessageReporter\Tests;

use Onoi\MessageReporter\ObservableMessageReporter;
use Onoi\MessageReporter\MessageReporter;

/**
 * @covers \Onoi\MessageReporter\ObservableMessageReporter
 * @group onoi-message-reporter
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ObservableMessageReporterTest extends MessageReporterTestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\ObservableMessageReporter',
			new ObservableMessageReporter()
		);
	}

	/**
	 * @return MessageReporter[]
	 */
	public function getInstances() {
		$instances = array();

		$instances[] = new ObservableMessageReporter();

		$reporter = new ObservableMessageReporter();
		$reporter->registerMessageReporter( new ObservableMessageReporter() );
		$callback0 = function( $string ) {};
		$callback1 = function( $string ) {};
		$instances[] = $reporter;

		$reporter = clone $reporter;
		$reporter->registerReporterCallback( $callback0 );
		$reporter->registerReporterCallback( $callback1 );
		$instances[] = $reporter;

		return $instances;
	}

	/**
	 * @dataProvider reportMessageProvider
	 *
	 * @param string $message
	 */
	public function testCallbackInvocation( $message ) {
		$callCount = 0;
		$asserter = array( $this, 'assertEquals' );

		$callback0 = function( $actual ) use ( $message, &$callCount, $asserter ) {
			$callCount += 1;
			call_user_func( $asserter, $message, $actual );
		};

		$callback1 = function( $actual ) use ( $message, &$callCount, $asserter ) {
			$callCount += 1;
			call_user_func( $asserter, $message, $actual );
		};

		$reporter = new ObservableMessageReporter();
		$reporter->registerReporterCallback( $callback0 );
		$reporter->registerReporterCallback( $callback1 );

		$reporter->reportMessage( $message );

		$this->assertEquals( 2, $callCount );

		$reporter->reportMessage( $message );

		$this->assertEquals( 4, $callCount );
	}

	/**
	 * @dataProvider reportMessageProvider
	 *
	 * @param string $message
	 */
	public function testReporterInvocation( $message ) {
		$callCount = 0;
		$asserter = array( $this, 'assertEquals' );

		$callback0 = function( $actual ) use ( $message, &$callCount, $asserter ) {
			$callCount += 1;
			call_user_func( $asserter, $message, $actual );
		};

		$callback1 = function( $actual ) use ( $message, &$callCount, $asserter ) {
			$callCount += 1;
			call_user_func( $asserter, $message, $actual );
		};

		$reporter0 = new ObservableMessageReporter();
		$reporter0->registerReporterCallback( $callback0 );

		$reporter1 = new ObservableMessageReporter();
		$reporter1->registerReporterCallback( $callback1 );

		$reporter = new ObservableMessageReporter();
		$reporter->registerMessageReporter( $reporter0 );
		$reporter->registerMessageReporter( $reporter1 );

		$reporter->reportMessage( $message );

		$this->assertEquals( 2, $callCount );

		$reporter->reportMessage( $message );

		$this->assertEquals( 4, $callCount );
	}

	public function testDoNoFailOnNotCallableHandler() {

		$reporter = new ObservableMessageReporter();

		$reporter->registerReporterCallback( null );
		$reporter->registerReporterCallback( array( $this, 'functionDoesNotExist' ) );

		$callCount = 0;

		$reporter->registerReporterCallback( function( $actual ) use ( &$callCount ) {
			$callCount += 1;
		} );

		$reporter->reportMessage( 'Foo' );

		$this->assertEquals(
			1,
			$callCount
		);
	}

}
