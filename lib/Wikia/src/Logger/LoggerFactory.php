<?php
namespace Wikia\Logger;

use Monolog\Handler\SocketHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerFactory {

	/** @var bool $shouldLogToStdOut */
	private $shouldLogToStdOut;

	/** @var bool $shouldExcludeDebugLevel */
	private $shouldExcludeDebugLevel;

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
			global $wgWikiaEnvironment, $wgLoggerLogToStdOutOnly;
			static::$instance = new self( $wgWikiaEnvironment === WIKIA_ENV_PROD, $wgLoggerLogToStdOutOnly );
		}

		return self::$instance;
	}

	public function __construct( bool $shouldExcludeDebugLevel, bool $shouldLogToStdOut = false ) {
		$this->shouldLogToStdOut = $shouldLogToStdOut;
		$this->shouldExcludeDebugLevel = $shouldExcludeDebugLevel;
	}

	public function getLogger( string $ident ): Logger {
		if( isset( $this->loggers[ $ident ] ) ) {
			return $this->loggers[ $ident ];
		}

		$logger = new Logger( $ident );

		if( $this->shouldLogToStdOut ) {
			// CORE=260 | STDOUT constant is not set when running in fpm mode
			if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'w'));
			$handler = new StreamHandler( STDOUT );
		} else {
			// TODO: remove when we fully migrate to k8s
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
