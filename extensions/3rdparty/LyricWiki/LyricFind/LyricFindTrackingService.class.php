<?php

/**
 * Provides an API for tracking page views on Lyrics Wiki
 */
class LyricFindTrackingService extends WikiaService {

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
		$data = array(
			'apikey' => $this->wg->LyricFindApiKeys['display'],
			'reqtype' => 'default',
			'trackid' => "amg:{$trackId}",
			'output' => 'json'
		);

		$client = new Http();
		$resp = $client->post($url, array(
			'postData' => $data
		));

		// get the code from API response
		if ($resp !== false) {
			$json = json_decode($resp, true);

			$code = intval($json['response']['code']);
			$success = in_array($code, array(
				101, // lyric is available
				102, // track is instrumental
				111 // LRC is available
			));

			// log errors
			if ($success === false) {
				Wikia::log(__METHOD__, false, "got #{$code} response code from API (for page #{$pageId})", true);
			}
		}
		else {
			$success = false;
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
		$dbr = wfGetDB( DB_SLAVE, array(), $this->wg->StatsDB);

		$trackId = $dbr->selectField(
			'lyricfind.lf_track',
			'track_id',
			array(
				'lw_id' => $pageId
			),
			__METHOD__
		);

		return !empty($trackId) ? intval($trackId) : false;
	}
}
