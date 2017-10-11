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
		$this->assertTrue($logger instanceof WikiaLogger);
		$this->assertTrue(WikiaLogger::getSyslogHandler('foo-test') instanceof SyslogHandler);
		$this->assertTrue($logger->getWebProcessor() instanceof WebProcessor);
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
