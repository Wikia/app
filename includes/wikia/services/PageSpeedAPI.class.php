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

		// prepare basic report
		$report = array(
			'url' => $resp['id'],
			'metrics' => array(
				'pageSpeed' => intval($resp['score'])
			)
		);

		// add the rest of the metrics
		$report['metrics'] += $resp['pageStats'];

		// serialized requests
		// "The following requests are serialized. Try to break up the dependencies to make them load in parallel."
		$report['metrics']['serializedRequests'] = $this->countReportedUrl($resp, 'AvoidExcessSerialization');

		// count redirects
		$report['metrics']['redirects'] = $this->countReportedUrl($resp, 'MinimizeRedirects');

		// count assets with short (less than 7 days) expiry time
		// "The following cacheable resources have a short freshness lifetime. Specify an expiration at least one week in the future for the following resources:"
		$report['metrics']['shortExpires'] = $this->countReportedUrl($resp, 'LeverageBrowserCaching');

		// count assets served uncompressed
		$report['metrics']['notGzipped'] = $this->countReportedUrl($resp, 'EnableGzipCompression');

		// count duplicated content served from different URLs
		$report['metrics']['duplicatedContent'] = $this->countReportedUrl($resp, 'ServeResourcesFromAConsistentUrl');

		// aggregate some of the stats
		$report['metrics']['totalResponseBytes'] = $resp['pageStats']['htmlResponseBytes'] +
			$resp['pageStats']['cssResponseBytes'] +
			$resp['pageStats']['imageResponseBytes'] +
			$resp['pageStats']['javascriptResponseBytes'] +
			(!empty($resp['pageStats']['otherResponseBytes']) ? $resp['pageStats']['otherResponseBytes'] : 0);

		return $report;
	}

	/**
	 * Count number of entries under "urls" key for a given rule
	 */
	private function countReportedUrl(Array $resp, $ruleName) {
		return (!empty($resp['formattedResults']['ruleResults'][$ruleName]['urlBlocks'][0]['urls']))
			? count($resp['formattedResults']['ruleResults'][$ruleName]['urlBlocks'][0]['urls'])
			: 0;
	}
}
