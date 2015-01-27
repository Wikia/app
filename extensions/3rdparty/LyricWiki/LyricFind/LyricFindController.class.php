<?php

/**
 * This controller sends HTTP request to LyricFind tracking API with the following data:
 *
 * - amgid (if available)
 * - gnlyricid (if available)
 * - page title (always) - controller should be called with title parameter passed
 */
class LyricFindController extends WikiaController {

	const RESPONSE_OK = 200;
	const RESPONSE_ERR = 404;

	public function track() {
		$amgId = intval($this->getVal('amgid'));
		$gracenoteId = intval($this->getVal('gracenoteid'));

		// make a request to LyricFind API
		$service = new LyricFindTrackingService();
		$status = $service->track($amgId, $gracenoteId, $this->wg->Title);

		// don't try to find a template for this controller's method
		$this->skipRendering();

		// debug response headers
		if (!$status->isOK()) {
			$errors = $status->getErrorsArray();
			$this->response->setHeader('X-LyricFind-API-Error', reset($errors)[0]);
		}

		if (!empty($status->value)) {
			$this->response->setHeader('X-LyricFind-API-Code', $status->value);
		}

		if ($status->isOK()) {
			// emit blank image - /skins/common/blank.gif
			$this->response->setCode(self::RESPONSE_OK);
			$this->response->setContentType('image/gif');

			// emit raw GIF content when not in CLI mode
			// i.e. not running unit tests
			if ( php_sapi_name() != 'cli' ) {
				echo file_get_contents($this->wg->StyleDirectory . '/common/blank.gif');
			}
		}
		else {
			$this->response->setCode(self::RESPONSE_ERR);
		}
	}
}
