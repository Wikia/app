<?php
/**
 * Wikia\Logger\WikiaLogger tests
 */

use Wikia\Logger\WikiaLogger;
use Wikia\Logger\SyslogHandler;
use Wikia\Logger\WebProcessor;
use PHPUnit\Framework\TestCase;

class WikiaLoggerTest extends TestCase {

	function testInstance() {
		$logger = WikiaLogger::instance();
		$this->assertInstanceOf( WikiaLogger::class,$logger );
		$this->assertInstanceOf( WebProcessor::class, $logger->getWebProcessor() );
	}

	function testLogger() {
		$loggerMock = $this->getMockBuilder( Monolog\Logger::class )
			->setConstructorArgs( [ 'phpunit' ] )
			->getMock();

		$loggerMock->expects($this->any())
			->method('debug')
			->will($this->returnValue('bar'));

		$logger = WikiaLogger::instance();
		$logger->setLogger($loggerMock);

		$this->assertEquals('bar', $logger->debug('foo'));
	}
}
