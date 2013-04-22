<?php

/**
 * Provides an API for tracking page views on Lyrics Wiki
 */
class LyricFindTrackingService extends WikiaService {

	const DEFAULT_USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19';

	/**
	 * @param $amgId int AMG (All Music Guide) lyric ID to track page view for
	 * @return bool success
	 */
	public function track($amgId) {
		wfProfileIn(__METHOD__);

		$url = $this->wg->LyricFindApiUrl . '/lyric.do';
		$data = [
			'apikey' => $this->wg->LyricFindApiKeys['display'],
			'reqtype' => 'default',
			'trackid' => "amg:{$amgId}",
			'output' => 'json',
			'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : self::DEFAULT_USER_AGENT
		];

		$resp = Http::post($url, ['postData' => $data]);

		if ($resp !== false) {
			wfDebug(__METHOD__ . ": API response - {$resp}\n");
		}

		// get the code from API response
		if ($resp !== false) {
			$json = json_decode($resp, true);

			$code = !empty($json['response']['code']) ? intval($json['response']['code']) : false;
			$success = in_array($code, [
				101, // lyric is available
				102, // track is instrumental
				111 // LRC is available
			]);

			// log errors
			if ($success === false) {
				Wikia::log(__METHOD__, false, "got #{$code} response code from API (track #{$amgId})", true);
			}
		}
		else {
			$success = false;
			Wikia::log(__METHOD__, false, "LyricFind API request failed!", true);
		}

		wfProfileOut(__METHOD__);
		return $success;
	}
}
