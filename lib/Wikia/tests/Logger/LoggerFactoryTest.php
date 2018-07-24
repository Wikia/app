<?php
namespace Wikia\Logger;

use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\SocketHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class LoggerFactoryTest extends TestCase {

	const LOG_SOCKET_ADDRESS = 'tcp://127.0.0.1:9999';

	/**
	 * @dataProvider identProvider
	 * @param string $ident
	 */
	public function testGetLoggerStdoutDebug( string $ident ) {
		$loggerFactory = new LoggerFactory( true, false, self::LOG_SOCKET_ADDRESS, true );

		$logger = $loggerFactory->getLogger( $ident );

		$this->assertCount( 1, $logger->getHandlers() );

		foreach ( $logger->getHandlers() as $handler ) {
			$this->assertInstanceOf( StreamHandler::class, $handler );
			$this->assertInstanceOf( LogstashFormatter::class, $handler->getFormatter() );

			$this->assertEquals( Logger::DEBUG, $handler->getLevel() );
		}

		$this->assertEquals( $ident, $logger->getName() );
	}

	/**
	 * @dataProvider identProvider
	 * @param string $ident
	 */
	public function testGetLoggerStdoutNoDebug( string $ident ) {
		$loggerFactory = new LoggerFactory( true, true, self::LOG_SOCKET_ADDRESS, true );

		$logger = $loggerFactory->getLogger( __METHOD__ . $ident );

		$this->assertCount( 1, $logger->getHandlers() );

		foreach ( $logger->getHandlers() as $handler ) {
			$this->assertInstanceOf( StreamHandler::class, $handler );
			$this->assertInstanceOf( LogstashFormatter::class, $handler->getFormatter() );

			$this->assertEquals( Logger::INFO, $handler->getLevel() );
		}

		$this->assertEquals( __METHOD__ . $ident, $logger->getName() );
	}

	/**
	 * @dataProvider identProvider
	 * @param string $ident
	 */
	public function testGetLoggerSocketDebug( string $ident ) {
		$loggerFactory = new LoggerFactory( true, false, self::LOG_SOCKET_ADDRESS );

		$logger = $loggerFactory->getLogger( $ident );

		$this->assertCount( 1, $logger->getHandlers() );

		foreach ( $logger->getHandlers() as $handler ) {
			$this->assertInstanceOf( SocketHandler::class, $handler );
			$this->assertInstanceOf( LogstashFormatter::class, $handler->getFormatter() );

			$this->assertEquals( Logger::DEBUG, $handler->getLevel() );
		}

		$this->assertEquals( $ident, $logger->getName() );
	}

	/**
	 * @dataProvider identProvider
	 * @param string $ident
	 */
	public function testGetLoggerSocketNoDebug( string $ident ) {
		$loggerFactory = new LoggerFactory( true, true, self::LOG_SOCKET_ADDRESS );

		$logger = $loggerFactory->getLogger( __METHOD__ . $ident );

		$this->assertCount( 1, $logger->getHandlers() );

		foreach ( $logger->getHandlers() as $handler ) {
			$this->assertInstanceOf( SocketHandler::class, $handler );
			$this->assertInstanceOf( LogstashFormatter::class, $handler->getFormatter() );

			$this->assertEquals( Logger::INFO, $handler->getLevel() );
		}

		$this->assertEquals( __METHOD__ . $ident, $logger->getName() );
	}

	/**
	 * @dataProvider identProvider
	 * @param string $ident
	 */
	public function testGetLoggerSyslogNoDebug( string $ident ) {
		$loggerFactory = new LoggerFactory( false, true, self::LOG_SOCKET_ADDRESS );

		$logger = $loggerFactory->getLogger( __METHOD__ . $ident );

		$this->assertCount( 1, $logger->getHandlers() );

		foreach ( $logger->getHandlers() as $handler ) {
			$this->assertInstanceOf( SyslogHandler::class, $handler );
			$this->assertInstanceOf( LogstashFormatter::class, $handler->getFormatter() );

			$this->assertEquals( Logger::INFO, $handler->getLevel() );
		}

		$this->assertEquals( __METHOD__ . $ident, $logger->getName() );
	}

	/**
	 * @dataProvider identProvider
	 * @param string $ident
	 */
	public function testGetLoggerSyslogDebug( string $ident ) {
		$loggerFactory = new LoggerFactory( false, false, self::LOG_SOCKET_ADDRESS );

		$logger = $loggerFactory->getLogger( __METHOD__ . $ident );

		$this->assertCount( 1, $logger->getHandlers() );

		foreach ( $logger->getHandlers() as $handler ) {
			$this->assertInstanceOf( SyslogHandler::class, $handler );
			$this->assertInstanceOf( LogstashFormatter::class, $handler->getFormatter() );

			$this->assertEquals( Logger::DEBUG, $handler->getLevel() );
		}

		$this->assertEquals( __METHOD__ . $ident, $logger->getName() );
	}

	public function identProvider() {
		yield [ 'mediawiki' ];
		yield [ 'mediawiki-sql' ];
	}
}
