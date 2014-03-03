<?php

namespace Wikia\Swift\Logger;

interface ILogger {
	public function log( $level, $message );
	public function prefix( $prefix );
	public function getPrefix();
}

class Logger implements ILogger {
	protected $printLevel;
	protected $fileName;
	public function __construct( $printLevel = 0, $sendLevel = 0, $writeLevel = 0 ) {
		$this->printLevel = $printLevel;
		$this->sendLevel = $sendLevel;
		$this->writeLevel = $writeLevel;
	}

	public function setFile( $fileName ) {
		$this->fileName = $fileName;
		$this->writeFile('------------------');
		$this->writeFile('Started: '.date('c'));
	}

	protected function writeFile( $message ) {
		$f = fopen($this->fileName,'a');
		fwrite($f,"{$message}\n");
		fclose($f);
	}

	public function log( $level, $message ) {
		if ( $level <= $this->printLevel ) {
			echo "{$message}\n";
		}
		if ( $level <= $this->sendLevel ) {
			\Wikia::log('SwiftMigration-WIKIA',false,$message,true);
		}
		if ( $level <= $this->writeLevel && $this->fileName) {
			$this->writeFile($message);
		}
	}

	public function prefix( $prefix ) {
		return new PrefixedLogger($this,$prefix);
	}
	public function getPrefix() {
		return '';
	}
}

class PrefixedLogger implements ILogger {
	/** @var ILogger $logger */
	protected $logger;
	protected $prefix;
	public function __construct( Logger $logger, $prefix ) {
		$this->logger = $logger;
		$this->prefix = $prefix ? $prefix . ': ' : '';
	}
	public function log( $level, $message ) {
		$this->logger->log($level,$this->prefix . $message );
	}
	public function prefix( $prefix ) {
		return new PrefixedLogger($this->logger,$this->prefix . $prefix);
	}
	public function getPrefix() {
		return $this->prefix;
	}
}

trait LoggerFeature {
	/** @var ILogger $logger */
	protected $logger;
	protected function getLoggerPrefix() { return null; }
	public function setLogger( ILogger $logger = null ) {
		if ( $logger === null ) { throw new \Exception(); }
		$prefix = $this->getLoggerPrefix();
		$this->logger = empty($prefix) ? $logger : $logger->prefix($prefix);
	}
	public function getLogger() {
		return $this->logger;
	}
	public function log( $level, $message ) {
		if ( $this->logger ) {
			$this->logger->log($level,$message);
		}
	}
	public function logError( $message ) {
		$this->log( 0, $message );
	}
	public function logWarning( $message ) {
		$this->log( 2, $message );
	}
	public function logInfo( $message ) {
		$this->log( 4, $message );
	}
	public function logDebug( $message ) {
		$this->log( 6, $message );
	}
	public function logTrace( $message ) {
		$this->log( 8, $message );
	}
	public function copyLogger( $source ) {
		/** @var LoggerFeature $source */
		$this->setLogger($source->getLogger());
	}
}