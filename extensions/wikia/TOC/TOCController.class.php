<?php

class TOCController extends WikiaController {

	public function index() {
		$this->response->addAsset('toc_js');

		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}

}