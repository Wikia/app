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


class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter {

	const APPNAME = 'mediawiki';

	/**
	 * @param string $appname
	 */
	public function __construct($appname = self::APPNAME) {
		parent::__construct($appname);
	}

	protected function formatV0(array $record) {
		$message = array(
			'appname' => $this->applicationName,
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

		return $message;
	}

	/**
	 * @param Exception}Throwable $e
	 * @return array
	 */
	protected function normalizeException($e) {
		if (!$e instanceof Exception && !$e instanceof \Throwable) {
			throw new \InvalidArgumentException('Exception/Throwable expected, got '.gettype($e).' / '.get_class($e));
		}

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
