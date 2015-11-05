<?php
/**
 * LogstashFormatter
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;
use Exception;


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

			if (!empty($record['context']['@root'])) {
				$message = array_merge($record['context']['@root'], $message);
				unset($record['context']['@root']);
			}

			$message['@context'] = $record['context'];
		}

		if ($this->isInDevMode()) {
			$message['@message'] = "DEV_ES_MESSAGE {$message['@message']}";
		}

		return $message;
	}

	protected function normalizeException(Exception $e) {
		$data = array(
			'class' => get_class($e),
			'message' => $e->getMessage(),
			'code' => $e->getCode(),
			'file' => $e->getFile().':'.$e->getLine(),
		);

		$trace = $e->getTrace();
		foreach ($trace as $frame) {
			if (isset($frame['file'])) {
				$data['trace'][] = $frame['file'].':'.$frame['line'];
			} else {
				// prevent huge json blobs from preventing message parsing (because of split message) and flooding file logs
				if (isset($frame['args'])) {
					unset($frame['args']);
				}

				$data['trace'][] = json_encode($frame);
			}
		}

		if ($previous = $e->getPrevious()) {
			$data['previous'] = $this->normalizeException($previous);
		}

		return $data;
	}
}
