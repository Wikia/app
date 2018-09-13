<?php
/**
 * WikiaLogger
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class WikiaLogger implements LoggerInterface {
	/** @var \Psr\Log\LoggerInterface */
	private $logger;

	/** @var WebProcessor */
	private $webProcessor;

	const SYSLOG_IDENT = 'mediawiki';

	/** private to enforce singleton */
	private function __construct() {
	}

	/**
	 * @return WikiaLogger
	 */
	public static function instance() {
		static $instance = null;

		if (!isset($instance)) {
			$instance = new WikiaLogger();
		}

		return $instance;
	}

	public function onError($code, $message, $file, $line, $context, $force=false) {
		// is this necessary? I thought the code is being passed in
		if ( !( $code & error_reporting() ) && !$force ) {
			return true;
		}

		$exit = false;

		switch ($code) {
			case E_NOTICE:
			case E_USER_NOTICE:
				$method = 'notice';
				$priorityString = 'Notice';
				break;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_USER_WARNING:
				$method = 'warning';
				$priorityString = 'Warning';
				break;
			case E_ERROR:
			case E_CORE_ERROR:
			case E_USER_ERROR:
			case E_RECOVERABLE_ERROR:
				$exit = true;
				$method = 'error';
				$priorityString = 'Fatal Error';
				break;
			case E_STRICT:
				$method = 'warning';
				$priorityString = 'Strict Standards';
				break;
			case E_PARSE:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				// compile-time errors don't call autoload callbacks, so let the standard php error log handle them - BAC-1225
				return false;
			default:
				return false;
		}

		$this->getLogger()->$method("PHP {$priorityString}: {$message} in {$file} on line {$line}", [
			'exception' => new \Exception(),
		]);

		if ($exit) {
			exit(1);
		}

		/**
		 * It is important to remember that the standard PHP error handler is completely bypassed
		 * for the error types specified by error_typesunless the callback function returns FALSE
		 *
		 * Return false will make it possible for XDebug to display an orange box with an error on devboxes
		 *
		 * @see PLATFORM-2377
		 */
		return false;
	}

	/**
	 * Super-hacky, but set_error_handler() does not catch the fatal-family of errors. Unfortunately, this results
	 * in double-logging these types of errors, but having the context is probably worth it.
	 */
	public function onShutdown() {
		$error = error_get_last();

		if ($error) {
			switch($error['type']) {
				case E_ERROR:
				case E_CORE_ERROR:
				case E_COMPILE_ERROR:
				case E_USER_ERROR:
					$this->onError($error['type'], $error['message'], $error['file'], $error['line'], null, true);
					break;
			}
		}

		global $wgCommandLineMode;

		if ($wgCommandLineMode) {
			$this->info(
				'MW_MAINTENANCE_MEMORY_USAGE',
				[ 'memory' => memory_get_peak_usage ( true ) ]
			);
		}
	}

	public function debugSampled($sampling, $message, Array $context=[]) {
		if ( ( new \Wikia\Util\Statistics\BernoulliTrial($sampling) )->shouldSample() ) {
			return $this->debug($message, $context);
		}
	}

	public function debug($message, Array $context=[]) {
		return $this->getLogger()->debug($message, $context);
	}

	public function info($message, Array $context=[]) {
		return $this->getLogger()->info($message, $context);
	}

	public function notice($message, Array $context=[]) {
		return $this->getLogger()->notice($message, $context);
	}

	public function warning($message, Array $context=[]) {
		$this->addStacktraceIfMissing($context);
		return $this->getLogger()->warning($message, $context);
	}

	public function error($message, Array $context=[]) {
		$this->addStacktraceIfMissing($context);
		return $this->getLogger()->error($message, $context);
	}

	public function critical($message, Array $context=[]) {
		$this->addStacktraceIfMissing($context);
		return $this->getLogger()->critical($message, $context);
	}

	public function alert($message, Array $context=[]) {
		$this->addStacktraceIfMissing($context);
		return $this->getLogger()->alert($message, $context);
	}

	public function emergency($message, Array $context=[]) {
		$this->addStacktraceIfMissing($context);
		return $this->getLogger()->emergency($message, $context);
	}

	public function log($level, $message, Array $context=[]) {} // NOOP

	private function addStacktraceIfMissing( array &$context ) {
		if ( !array_key_exists( 'exception', $context ) ) {
			$context['exception'] = new \Exception();
		}
	}

	public function setLogger(Logger $logger) {
		$this->logger = $logger;
	}

	public function getLogger(): Logger {
		if ( $this->logger === null ) {
			$this->logger = LoggerFactory::getInstance()->getLogger( self::SYSLOG_IDENT );
			$this->logger->pushProcessor( $this->getWebProcessor() );
		}

		return $this->logger;
	}

	public function getWebProcessor(): WebProcessor {
		if ($this->webProcessor == null) {
			$this->webProcessor = new WebProcessor();
		}

		return $this->webProcessor;
	}

	/** @see \Wikia\Logger\WebProcessor::pushContext */
	public function pushContext(array $context, $type=WebProcessor::RECORD_TYPE_CONTEXT) {
		$this->getWebProcessor()->pushContext($context, $type);
	}

	/** @see \Wikia\Logger\WebProcessor::pushContextSource */
	public function pushContextSource(ContextSource $contextSource, $type=WebProcessor::RECORD_TYPE_CONTEXT) {
		$this->getWebProcessor()->pushContextSource($contextSource, $type);
	}

	/** @see \Wikia\Logger\WebProcessor::popContext */
	public function popContext($type=WebProcessor::RECORD_TYPE_CONTEXT) {
		$this->getWebProcessor()->popContext($type);
	}
}
