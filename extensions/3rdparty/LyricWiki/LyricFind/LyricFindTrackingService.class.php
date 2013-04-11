<?php

/**
 * Provides an API for tracking page views on Lyrics Wiki
 */
class LyricFindTrackingService extends WikiaService {

	const TTL = 86400; // 24h

	/**
	 * @param $pageId int page ID to track page view for
	 * @return bool success
	 */
	public function track($pageId) {
		wfProfileIn(__METHOD__);

		$trackId = $this->getTrackId($pageId);
		if ($trackId === false) {
			Wikia::log(__METHOD__, false, "can't get track ID for page #{$pageId}", true);

			wfProfileOut(__METHOD__);
			return false;
		}

		$url = $this->wg->LyricFindApiUrl . '/lyric.do';
		$data = [
			'apikey' => $this->wg->LyricFindApiKeys['display'],
			'reqtype' => 'default',
			'trackid' => "amg:{$trackId}",
			'output' => 'json'
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
				Wikia::log(__METHOD__, false, "got #{$code} response code from API (for page #{$pageId} / track #{$trackId})", true);
			}
		}
		else {
			$success = false;
			Wikia::log(__METHOD__, false, "LyricFind API request failed!", true);
		}

		wfProfileOut(__METHOD__);
		return $success;
	}

	/**
	 * Gets All Music Guide track ID for page with given ID
	 *
	 * @param $pageId int page ID
	 * @return string AMG track ID
	 */
	private function getTrackId($pageId) {
		$trackId =WikiaDataAccess::cache(__METHOD__ . "::{$pageId}", self::TTL, function() use ($pageId) {
			$dbr = $this->wf->GetDB(DB_SLAVE, [], $this->wg->StatsDB);

			return $dbr->selectField(
				'lyricfind.lf_track',
				'track_id',
				['lw_id' => $pageId],
				__METHOD__
			);
		});

		return !empty($trackId) ? intval($trackId) : false;
	}
}
