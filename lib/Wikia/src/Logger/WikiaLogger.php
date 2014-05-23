<?php
/**
 * WikiaLogger
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;

use Monolog\Logger;

class WikiaLogger {
	/** @var \Psr\Log\LoggerInterface */
	private $logger;

	/** @var SyslogHandler */
	private $syslogHandler;

	/** @var WebProcessor */
	private $webProcessor;

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

	public function onError($code, $message, $file, $line, $context) {
		// is this necessary? I thought the code is being passed in
		if (!($code & $this->getErrorReporting())) {
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
				$exit = true;
				$method = 'error';
				$priorityString = 'Fatal Error';
				break;
			case E_STRICT:
			case E_PARSE:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:
			case E_DEPRECATED:
				// compile-time errors don't call autoload callbacks, so let the standard php error log handle them - BAC-1225
				return false;
			default:
				return false;
		}

		$this->getLogger()->$method("PHP {$priorityString}: {$message} in {$file} on line {$line}");

		if ($exit) {
			exit(1);
		}

		return true;
	}

	public function debug($message, $context=[]) {
		return $this->getLogger()->debug($message, $context);
	}

	public function info($message, $context=[]) {
		return $this->getLogger()->info($message, $context);
	}

	public function notice($message, $context=[]) {
		return $this->getLogger()->notice($message, $context);
	}

	public function warning($message, $context=[]) {
		return $this->getLogger()->warning($message, $context);
	}

	public function error($message, $context=[]) {
		return $this->getLogger()->error($message, $context);
	}

	public function critical($message, $context=[]) {
		return $this->getLogger()->critical($message, $context);
	}

	public function alert($message, $context=[]) {
		return $this->getLogger()->alert($message, $context);
	}

	public function emergency($message, $context=[]) {
		return $this->getLogger()->emergency($message, $context);
	}

	public function setLogger(Logger $logger) {
		$this->logger = $logger;
	}

	public function getLogger() {
		if ($this->logger == null) {
			$this->logger = $this->defaultLogger();
		}

		return $this->logger;
	}

	/**
	 * @return \SyslogHandler
	 */
	public function getSyslogHandler() {
		if ($this->syslogHandler == null) {
			$this->syslogHandler = new SyslogHandler($this->detectIdent());
		}

		return $this->syslogHandler;
	}

	/**
	 * Set the SyslogHandler. Throws an exception of the logger has already been initialized.
	 *
	 * @param SyslogHandler $handler
	 */
	public function setSyslogHandler(SyslogHandler $handler) {
		if (isset($this->logger)) {
			throw new InvalidArgumentException("Error, \$this->logger has been initialized.");
		}

		$this->syslogHandler = $handler;
	}

	/**
	 * @return \WebProcessor.
	 */
	public function getWebProcessor() {
		if ($this->webProcessor == null) {
			$this->webProcessor = new WebProcessor();
		}

		return $this->webProcessor;
	}

	/**
	 * Sets the WebProcessor. Throws an exception of the logger has already been initialized.
	 *
	 * @param WebProcessor $processor
	 */
	public function setWebProcessor(WebProcessor $processor) {
		if (isset($this->logger)) {
			throw new InvalidArgumentException("Error, \$this->logger has been initialized.");
		}

		$this->webProcessor = $processor;
	}

	/**
	 * Creates the default logger.
	 *
	 * @return Logger
	 */
	public function defaultLogger() {
		return new Logger(
			'default',
			[$this->getSyslogHandler()],
			[$this->getWebProcessor()]
		);
	}

	/**
		* @return string enum['php', 'apache2']
	 */
	public function detectIdent() {
		return PHP_SAPI == 'cli' ? 'php' : 'apache2';
	}


	public function getErrorReporting() {
		return error_reporting();
	}
}
