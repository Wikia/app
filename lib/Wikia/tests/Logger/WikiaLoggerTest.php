<?php
/**
 *
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

	function testDetectIdent() {
		$ident = WikiaLogger::instance()->detectIdent();
		$this->assertTrue(!empty($ident));
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

	// FIXME: test onError

}
