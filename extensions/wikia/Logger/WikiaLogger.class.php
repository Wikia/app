<?php
/**
 * WikiaErrorHandler
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;

use Monolog\Logger;

class WikiaLogger {
	/** @var \Psr\Log\LoggerInterface */
	private $logger;

	private function __construct() {
		$ident = PHP_SAPI == 'cli' ? 'php' : 'apache2';
		$this->logger = new Logger(
			'default',
			[new SyslogHandler($ident)],
			[new WebProcessor()]
		);
	}

	public static function instance() {
		static $instance = null;

		if ($instance == null) {
			$instance = new WikiaLogger();
		}

		return $instance;
	}

	public function logger() {
		return $this->logger;
	}

	public function onError($code, $message, $file, $line, $context) {
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
				$method = 'info';
				$priorityString = 'Strict Standards';
				break;
			default:
				return false;
		}

		$this->logger->$method("PHP {$priorityString}: {$message} in {$file} on line {$line}");

		if ($exit) {
			exit(1);
		}

		return true;
	}
} 