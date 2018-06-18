<?php
namespace Wikia\Logger;

use Monolog\Handler\SocketHandler;
use Monolog\Logger;

class LoggerFactory {

	/** @var bool $shouldLogToStandardOutput */
	private $shouldLogToSocket;

	/** @var bool $shouldExcludeDebugLevel */
	private $shouldExcludeDebugLevel;

	/** @var string $socketAddress */
	private $socketAddress;

	/** @var StatusProcessor $statusProcessor */
	private $statusProcessor;

	/** @var Logger[] $loggers */
	private $loggers;

	/** @var LoggerFactory $instance */
	private static $instance;

	/**
	 * @return LoggerFactory
	 */
	public static function getInstance(): LoggerFactory {
		if( static::$instance === null ) {
			global $wgWikiaEnvironment, $wgLoggerLogToSocketOnly, $wgLoggerSocketAddress;

			static::$instance = new self( $wgLoggerLogToSocketOnly, $wgWikiaEnvironment === WIKIA_ENV_PROD, $wgLoggerSocketAddress );
		}

		return self::$instance;
	}

	public function __construct( bool $shouldLogToSocket, bool $shouldExcludeDebugLevel, string $socketAddress ) {
		$this->shouldLogToSocket = $shouldLogToSocket;
		$this->shouldExcludeDebugLevel = $shouldExcludeDebugLevel;
		$this->socketAddress = $socketAddress;
	}

	public function getLogger( string $ident ): Logger {
		if( isset( $this->loggers[ $ident ] ) ) {
			return $this->loggers[ $ident ];
		}

		$logger = new Logger( $ident );

		if( $this->shouldLogToSocket ) {
			$handler = new SocketHandler( $this->socketAddress );
		} else {
			$handler = new SyslogHandler( $ident );
		}

		$handler->setFormatter( new LogstashFormatter( $ident ) );

		if( $this->shouldExcludeDebugLevel ) {
			$handler->setLevel( Logger::INFO );
		}

		$logger->pushHandler( $handler );
		$logger->pushProcessor( $this->getStatusProcessor() );

		return ( $this->loggers[ $ident ] = $logger );
	}

	/**
	 * @return StatusProcessor
	 */
	private function getStatusProcessor(): StatusProcessor {
		if( $this->statusProcessor === null ) {
			$this->statusProcessor = new StatusProcessor();
		}

		return $this->statusProcessor;
	}
}
