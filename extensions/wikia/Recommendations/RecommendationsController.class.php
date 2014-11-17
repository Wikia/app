<?php

class RecommendationsController extends WikiaController {

	public function index() {
		global $wgBlankImgUrl;

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		/**
		 * These variables are only for recommendations layout.
		 * Should be replaced during work on Recommendations API
		 */
		$this->linkUrl = '#';
		$this->blankImg = $wgBlankImgUrl;
		$this->header = wfMessage('recommendations-header')->escaped();
	}
}
