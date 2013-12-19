<?php
/**
 * WebProcessor
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 * @see \Monolog\Processor\WebProcessor
 */

namespace Wikia\Logger;


class WebProcessor {
	public function __invoke(array $record) {
		static $mergeData = null;

		if (!isset($_SERVER['REQUEST_URI'])) {
			return $record;
		} elseif ($mergeData == null) {
			global $wgRequest;

			$mergeData = [
				'url' => $_SERVER['REQUEST_URI'],
				'ip' => !empty($wgRequest) ? $wgRequest->getIP() : null,
				'http_method' => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null,
				'server' => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null,
				'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
			];
		}

		if (isset($_SERVER['UNIQUE_ID'])) {
			$record['extra']['unique_id'] = $_SERVER['UNIQUE_ID'];
		}

		$record['extra'] = array_merge($record['extra'], $mergeData);

		return $record;
	}
} 