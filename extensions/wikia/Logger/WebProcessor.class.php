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

		if ($mergeData == null) {
			global $wgRequest, $wgDBname, $wgCityId;
			$mergeData = [];

			if (!empty($wgDBname)) {
				$mergeData['db_name'] = $wgDBname;
			}

			if (!empty($wgCityId)) {
				$mergeData['city_id'] = $wgCityId;
			}

			if (isset($_SERVER['REQUEST_URI'])) {
				$mergeData['url'] = $_SERVER['REQUEST_URI'];

				$ip = !empty($wgRequest) ? $wgRequest->getIP() : null;
				if ($ip === null) {
					$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
				}

				if ($ip != null) {
					$mergeData['ip'] = $ip;
				}

				if (isset($_SERVER['REQUEST_METHOD'])) {
					$mergeData['http_method'] = $_SERVER['REQUEST_METHOD'];
				}

				if (isset($_SERVER['SERVER_NAME'])) {
					$mergeData['server'] = $_SERVER['SERVER_NAME'];
				}

				if (isset($_SERVER['HTTP_REFERER'])) {
					$mergeData['referrer'] = $_SERVER['HTTP_REFERER'];
				}

				if (isset($_SERVER['UNIQUE_ID'])) {
					$mergeData['unique_id'] = $_SERVER['UNIQUE_ID'];
				}
			}
		}

		$record['extra'] = array_merge($record['extra'], $mergeData);

		return $record;
	}
} 