<?php
/**
 * Wikia\Logger\WikiaLogger tests
 */

use Wikia\Logger\WikiaLogger;
use Wikia\Logger\SyslogHandler;
use Wikia\Logger\WebProcessor;

class WikiaLoggerTest extends PHPUnit_Framework_TestCase {

	function testInstance() {
		$logger = WikiaLogger::instance();
		$this->assertTrue($logger instanceof WikiaLogger);
		$this->assertTrue($logger->getSyslogHandler() instanceof SyslogHandler);
		$this->assertTrue($logger->getWebProcessor() instanceof WebProcessor);
	}

	function testLogger() {
		$loggerMock = $this->getMock('\Monolog\Logger', [], ['phpunit']);
		$loggerMock->expects($this->any())
			->method('debug')
			->will($this->returnValue('bar'));

		$logger = WikiaLogger::instance();
		$logger->setLogger($loggerMock);

		$this->assertEquals('bar', $logger->debug('foo'));
	}

	function testOnError() {
		$wikiaLoggerMock = $this->getMock('\Wikia\Logger\WikiaLogger', ['getErrorReporting'], [], '', false);

		$loggerMock = $this->getMock('\Monolog\Logger', [], ['phpunit']);
		$loggerMock->expects($this->atLeastOnce())
			->method('notice')
			->will($this->returnValue('bar'));

		$wikiaLoggerMock->expects($this->atLeastOnce())
			->method('getErrorReporting')
			->will($this->returnValue(E_NOTICE));

		$wikiaLoggerMock->setLogger($loggerMock);
		$this->assertFalse($wikiaLoggerMock->onError(E_NOTICE, 'foo', __FILE__, __LINE__, 'here'));
	}

}
