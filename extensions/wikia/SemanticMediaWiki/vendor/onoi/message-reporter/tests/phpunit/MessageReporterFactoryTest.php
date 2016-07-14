<?php

namespace Onoi\MessageReporter\Tests;

use Onoi\MessageReporter\MessageReporterFactory;

/**
 * @covers \Onoi\MessageReporter\MessageReporterFactory
 *
 * @group onoi-message-reporter
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CacheFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\MessageReporterFactory',
			new MessageReporterFactory()
		);

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\MessageReporterFactory',
			MessageReporterFactory::getInstance()
		);
	}

	public function testClear() {

		$instance = MessageReporterFactory::getInstance();

		$this->assertSame(
			$instance,
			MessageReporterFactory::getInstance()
		);

		$instance->clear();

		$this->assertNotSame(
			$instance,
			MessageReporterFactory::getInstance()
		);
	}

	public function testNewNullMessageReporter() {

		$instance =	new MessageReporterFactory();

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\NullMessageReporter',
			$instance->newNullMessageReporter()
		);
	}

	public function testNewObservableMessageReporter() {

		$instance =	new MessageReporterFactory();

		$this->assertInstanceOf(
			'\Onoi\MessageReporter\ObservableMessageReporter',
			$instance->newObservableMessageReporter()
		);
	}

}
