<?php

/**
 * This controller sends HTTP request to LyricFind tracking API with the following data:
 *
 * - amgid (if available)
 * - gnlyricid (if available)
 * - page title (always) - controller should be called with title parameter passed
 */
class LyricFindController extends WikiaController {

	const RESPONSE_OK = 204;
	const RESPONSE_ERR = 404;

	public function track() {
		$amgId = intval($this->getVal('amgid'));
		$gracenoteId = intval($this->getVal('gracenoteid'));

		// make a request to LyricFind API
		$service = new LyricFindTrackingService();
		$res = $service->track($amgId, $gracenoteId, $this->wg->Title);

		$this->response->setFormat('json');
		$this->response->setCode( $res ? self::RESPONSE_OK : self::RESPONSE_ERR /* bad request */ );
	}
}
