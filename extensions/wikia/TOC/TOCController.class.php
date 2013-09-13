<?php

class TOCController extends WikiaController {

	public function index() {
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}

}