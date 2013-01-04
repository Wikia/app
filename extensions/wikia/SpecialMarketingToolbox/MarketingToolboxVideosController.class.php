<?php

class MarketingToolboxVideosController extends WikiaController {
	public function index() {
		$this->elementHeight = MarketingToolboxModel::FORM_THUMBNAIL_SIZE;
		$this->video = $this->request->getVal('video');
	}
}
