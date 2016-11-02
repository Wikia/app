<?php

namespace Onoi\MessageReporter\Tests;

use Onoi\MessageReporter\SpyMessageReporter;

/**
 * @covers \Onoi\MessageReporter\SpyMessageReporter
 * @group onoi-message-reporter
 *
 * @license GNU GPL v2+
 * @since 1.2
 *
 * @author mwjames
 */
class SpyMessageReporterTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\SpyMessageReporter',
			new SpyMessageReporter()
		);
	}

	public function testSpyOnReportedMessages() {

		$instance = new SpyMessageReporter();
		$instance->reportMessage( 'foo' );

		$this->assertEquals(
			array( 'foo' ),
			$instance->getMessages()
		);

		$instance->reportMessage( 'Bar' );

		$this->assertEquals(
			'foo, Bar',
			$instance->getMessagesAsString()
		);
	}

	public function testClearMessages() {

		$instance = new SpyMessageReporter();
		$instance->reportMessage( 'foo' );

		$this->assertNotEmpty(
			$instance->getMessages()
		);

		$instance->clearMessages();

		$this->assertEmpty(
			$instance->getMessages()
		);
	}

}
