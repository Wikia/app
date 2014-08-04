<?php
/**
 * LogstashFormatter
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;


class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter implements DevModeFormatterInterface {
	private $devMode = false;

	public function enableDevMode() {
		$this->devMode = true;
	}

	public function disableDevMode() {
		$this->devMode = false;
	}

	public function isInDevMode() {
		return $this->devMode === true;
	}

	protected function formatV0(array $record) {
		$message = array(
			'@timestamp' => $record['datetime'],
			'@message' => $record['message'],
		);

		if (!empty($record['extra'])) {
			$message['@fields'] = $record['extra'];
		}

		if (!empty($record['context'])) {
			if (!empty($record['context']['exception'])) {
				$message['@exception'] = $record['context']['exception'];
				unset($record['context']['exception']);
			}

			$message['@context'] = $record['context'];
		}

		if ($this->isInDevMode()) {
			$message['@message'] = "DEV_ES_MESSAGE {$message['@message']}";
		}

		return $message;
	}
}
