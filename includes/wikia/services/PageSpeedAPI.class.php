<?php

class PageSpeedAPI extends Service {

	const PAGESPPED_API_URL = 'https://www.googleapis.com/pagespeedonline/v1/runPagespeed';

	private $apiKey;

	function __construct() {
		global $wgGooglePageSpeedKey;
		$this->apiKey = $wgGooglePageSpeedKey;
	}

	/**
	 * Return PageSpeed score and page statistics for a given URL
	 *
	 * @see http://code.google.com/intl/pl/apis/pagespeedonline/v1/getting_started.html#examples
	 *
	 * @param string $url page URL
	 * @return mixed report
	 */
	public function getReport($url) {
		$apiUrl = self::PAGESPPED_API_URL . '?' . http_build_query(array(
			'url' => $url,
			'key' => $this->apiKey,
		));

		$resp = Http::get($apiUrl);

		if (empty($resp)) {
			return false;
		}

		$resp = json_decode($resp, true);

		$report = array(
			'url' => $resp['id'],
			'score' => intval($resp['score']),
			'stats' => $resp['pageStats'],
		);

		// aggregate some of the stats
		$report['stats']['totalResponseBytes'] = $resp['pageStats']['htmlResponseBytes'] +
			$resp['pageStats']['cssResponseBytes'] +
			$resp['pageStats']['imageResponseBytes'] +
			$resp['pageStats']['javascriptResponseBytes'] +
			$resp['pageStats']['otherResponseBytes'];

		return $report;
	}
}
