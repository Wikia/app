<?php

class LyricFindController extends WikiaController {

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

		$this->response->setCode( $res ? 204 : 400 /* bad request */ );
	}
}
