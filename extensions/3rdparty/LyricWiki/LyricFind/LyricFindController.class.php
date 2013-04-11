<?php

class LyricFindController extends WikiaController {

	const RESPONSE_OK = 204;
	const RESPONSE_ERR = 400;

	public function track() {
		$pageId = intval($this->getVal('pageid'));

		if ($pageId > 0) {
			// make a request to LyricFind API
			$service = new LyricFindTrackingService();
			$res = $service->track($pageId);
		}
		else {
			$res = false;
		}

		$this->response->setFormat('json');
		$this->response->setCode( $res ? self::RESPONSE_OK : self::RESPONSE_ERR /* bad request */ );
	}
}
