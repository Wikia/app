<?php

class LyricFindController extends WikiaController {

	public function track() {
		$pageId = intval($this->getVal('pageid'));

		if ($pageId > 0) {
			// make a request to LyricFind API
			$res = $this->doTrack($pageId);
		}
		else {
			$res = false;
		}

		$this->response->setCode( $res ? 204 : 400 /* bad request */ );
	}

	/**
	 * @param $pageId int page ID to track page view for
	 * @return bool success
	 */
	private function doTrack($pageId) {
		wfProfileIn(__METHOD__);

		$url = $this->wg->LyricFindApiUrl . '/lyric.do';
		$trackId = $this->getTrackId($pageId);
		$data = array(
			'apikey' => $this->wg->LyricFindApiKeys['display'],
			'reqtype' => 'default',
			'trackid' => $trackId,
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
		// perform a query
		return 'amg:3039';
	}
}
