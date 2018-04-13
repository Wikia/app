<?php
namespace Wikia\Logger;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerFactory {

	/** @var bool $shouldLogToStandardOutput */
	private $shouldLogToStandardOutput;

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
		if ( static::$instance === null ) {
			global $wgWikiaEnvironment, $wgLoggerLogToStdOutOnly;

			static::$instance = new self( $wgLoggerLogToStdOutOnly, $wgWikiaEnvironment === WIKIA_ENV_PROD );
		}

		return self::$instance;
	}

	public function __construct( bool $shouldLogToStandardOutput, bool $shouldExcludeDebugLevel ) {
		$this->shouldLogToStandardOutput = $shouldLogToStandardOutput;
		$this->shouldExcludeDebugLevel = $shouldExcludeDebugLevel;
	}

	public function getLogger( string $ident ): Logger {
		if ( isset( $this->loggers[$ident] ) ) {
			return $this->loggers[$ident];
		}

		$logger = new Logger( $ident );

		if ( $this->shouldLogToStandardOutput ) {
			$handler = new StreamHandler( STDOUT );
			$handler->setFormatter( new JsonFormatter( JsonFormatter::BATCH_MODE_NEWLINES ) );
		} else {
			$handler = new SyslogHandler( $ident );
			$handler->setFormatter( new LogstashFormatter( $ident ) );
		}

		if ( $this->shouldExcludeDebugLevel ) {
			$handler->setLevel( Logger::INFO );
		}

		$logger->pushHandler( $handler );
		$logger->pushProcessor( $this->getStatusProcessor() );

		return ( $this->loggers[$ident] = $logger );
	}

	/**
	 * @return StatusProcessor
	 */
	private function getStatusProcessor(): StatusProcessor {
		if ( $this->statusProcessor === null ) {
			$this->statusProcessor = new StatusProcessor();
		}

		return $this->statusProcessor;
	}
}
