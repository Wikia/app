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
		$this->assertInstanceOf( SyslogHandler::class, WikiaLogger::getSyslogHandler('foo-test') );
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

	function testOnError() {
		$wikiaLoggerMock = $this->getMockBuilder( WikiaLogger::class )
			->setMethods( [ 'getErrorReporting' ] )
			->disableOriginalConstructor()
			->getMock();

		$loggerMock = $this->getMockBuilder( Monolog\Logger::class )
			->setConstructorArgs( [ 'phpunit' ] )
			->getMock();

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
