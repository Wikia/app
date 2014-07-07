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
			$message['@fields'] = [];
			foreach ($record['extra'] as $key => $val) {
				$message['@fields'][$key] = $val;
			}
		}

		if (!empty($record['context'])) {
			$message['@context'] = [];
			foreach ($record['context'] as $key => $val) {
				$message['@context'][$key] = $val;
			}
		}

		if ($this->isInDevMode()) {
			$message['@message'] = "DEV_ES_MESSAGE {$message['@message']}";
		}

		return $message;
	}
}
