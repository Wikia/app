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

		$this->response->setCode( $res ? 204 : 500 );
	}

	/**
	 * @param $pageId int page ID to track page view for
	 * @return bool success
	 */
	private function doTrack($pageId) {
		wfProfileIn(__METHOD__);

		// TODO: get trackId from pageId
		$trackId = 'amg:3039';

		$url = $this->wg->LyricFindApiUrl . '/lyric.do';
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
		}
		else {
			$success = false;
		}

		wfProfileOut(__METHOD__);
		return $success;
	}
}
