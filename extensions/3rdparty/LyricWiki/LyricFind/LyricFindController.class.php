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
		$status = $service->track($amgId, $gracenoteId, $this->wg->Title);

		// debug response headers
		if (!$status->isOK()) {
			$errors = $status->getErrorsArray();
			$this->response->setHeader('X-LyricFind-API-Error', reset($errors)[0]);
		}

		if (!empty($status->value)) {
			$this->response->setHeader('X-LyricFind-API-Code', $status->value);
		}

		$this->response->setFormat('json');
		$this->response->setCode( $status->isOK() ? self::RESPONSE_OK : self::RESPONSE_ERR /* API error */ );
	}
}
