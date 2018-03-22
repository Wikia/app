<?php

namespace Onoi\MessageReporter\Tests;

use Onoi\MessageReporter\NullMessageReporter;

/**
 * @covers \Onoi\MessageReporter\NullMessageReporter
 *
 * @group onoi-message-reporter
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullMessageReporterTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\NullMessageReporter',
			new NullMessageReporter()
		);
	}

	public function testReportMessage() {

		$instance = new NullMessageReporter();

		$this->assertNull(
			$instance->reportMessage( 'foo' )
		);
	}

}
