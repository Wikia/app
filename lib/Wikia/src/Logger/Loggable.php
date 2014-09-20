<?php
/**
 * Loggable
 *
 * Trait to allow objects to log with a common context
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;

trait Loggable {
	/**
	 * context key/val pairs that all log messages coming from this class must have
	 * @return array
	 */
	protected function getLoggerContext() {
		return [];
	}

	private function mergeLoggerContext(array $context) {
		return array_merge($this->getLoggerContext(), $context);
	}

	public function debug($message, array $context=[]) {
		return WikiaLogger::instance()->debug($message, $this->mergeLoggerContext($context));
	}

	public function info($message, array $context=[]) {
		return WikiaLogger::instance()->info($message, $this->mergeLoggerContext($context));
	}

	public function notice($message, array $context=[]) {
		return WikiaLogger::instance()->notice($message, $this->mergeLoggerContext($context));
	}

	public function warning($message, array $context=[]) {
		return WikiaLogger::instance()->warning($message, $this->mergeLoggerContext($context));
	}

	public function error($message, array $context=[]) {
		return WikiaLogger::instance()->error($message, $this->mergeLoggerContext($context));
	}

	public function critical($message, array $context=[]) {
		return WikiaLogger::instance()->critical($message, $this->mergeLoggerContext($context));
	}

	public function alert($message, array $context=[]) {
		return WikiaLogger::instance()->alert($message, $this->mergeLoggerContext($context));
	}

	public function emergency($message, array $context=[]) {
		return WikiaLogger::instance()->emergency($message, $this->mergeLoggerContext($context));
	}
}
