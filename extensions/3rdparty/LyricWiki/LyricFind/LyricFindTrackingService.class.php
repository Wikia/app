<?php

/**
 * Provides an API for tracking page views on Lyrics Wiki
 */
class LyricFindTrackingService extends WikiaService {

	// LyricFind API response codes
	const CODE_LYRIC_IS_AVAILABLE = 101;
	const CODE_LYRIC_IS_INSTRUMENTAL = 102;
	const CODE_LRC_IS_AVAILABLE  = 111;
	const CODE_LYRIC_IS_BLOCKED  = 206;

	const DEFAULT_USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19';

	/**
	 * Marks given page with lyric for removal
	 *
	 * @param $pageId int article ID
	 * @return bool result
	 */
	private function markLyricForRemoval($pageId) {
		$this->wf->SetWikiaPageProp(WPP_LYRICFIND_MARKED_FOR_REMOVAL, $pageId, 1);

		Wikia::log(__METHOD__, false, "marked #{$pageId} for removal", true);
		return true;
	}

	/**
	 * Returns properly formatted "trackid" parameter for LyricFind API from given data
	 *
	 * Example: trackid=amg:2033,gnlyricid:123,trackname:mony+mony,artistname:tommy+james
	 *
	 * @param $data array containing amgid, gnlyricid and title of the lyric
	 */
	private function formatTrackId($data) {
		$parts = [];

		if (!empty($data['amg'])) {
			$parts[] = sprintf('amg:%d', $data['amg']);
		}

		if (!empty($data['gracenote'])) {
			$parts[] = sprintf('gnlyricid:%d', $data['gracenote']);
		}

		list($artistName, $trackName) = explode(':', $data['title'], 2);

		// artist and track name needs to be lowercase and without commas
		$parts[] = sprintf('trackname:%s', mb_strtolower(str_replace(',', ' ', $trackName)));
		$parts[] = sprintf('artistname:%s', mb_strtolower(str_replace(',', ' ', $artistName)));

		return join(',', $parts);
	}

	/**
	 * @param $amgId int|bool AMG (All Music Guide) lyric ID to track page view for (or false if not found)
	 * @param $gracenoteId int|bool Gracenote lyric ID to track page view for (or false if not found)
	 * @param $title Title page with the lyric to track
	 * @return bool success
	 */
	public function track($amgId, $gracenoteId, Title $title) {
		wfProfileIn(__METHOD__);

		// format trackid parameter
		$trackId = $this->formatTrackId([
			'amg' => $amgId,
			'gracenote' => $gracenoteId,
			'title' => $title->getText()
		]);

		$url = $this->wg->LyricFindApiUrl . '/lyric.do';
		$data = [
			'apikey' => $this->wg->LyricFindApiKeys['display'],
			'reqtype' => 'offlineviews',
			'count' => 1,
			'trackid' => $trackId,
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

			// mark lyrics for removal
			if ($code == self::CODE_LYRIC_IS_BLOCKED) {
				$success = $this->markLyricForRemoval($this->wg->Title->getArticleID());
			}
			else {
				$success = in_array($code, [
					self::CODE_LRC_IS_AVAILABLE,
					self::CODE_LYRIC_IS_INSTRUMENTAL,
					self::CODE_LYRIC_IS_AVAILABLE
				]);

				// log errors
				if ($success === false) {
					Wikia::log(__METHOD__, false, "got #{$code} response code from API (track #{$amgId})", true);
				}
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
