<?php
/**
 * Sends logs to S3, see OPS-11593
 */

namespace Wikia\Logger;

use \Monolog\Formatter\LineFormatter;
use Monolog\Logger;

class S3AuditLogger extends WikiaLogger {

	/** private to enforce singleton */
	private function __construct() {
	}

	/**
	 * @return S3AuditLogger
	 */
	public static function instance() {
		static $instance = null;

		if (!isset($instance)) {
			echo "instance";
			$instance = new S3AuditLogger();
		}

		return $instance;
	}

	/**
	 * Creates the default logger.
	 *
	 * @param string $ident
	 * @return Logger
	 */
	public function defaultLogger($ident = self::SYSLOG_IDENT) {
		echo "defaultLogger";
		$handler = self::getSyslogHandler($ident);
		$formatter = new LineFormatter("s3auditlog %channel%.%level_name%: %message% %context% %extra%");
		$handler->setFormatter($formatter);
		return new Logger(
			'default',
			[$handler]);
	}
}
