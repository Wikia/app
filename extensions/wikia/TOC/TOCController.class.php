<?php

class TOCController extends WikiaController {

	public function index() {

		$this->tocHeader = wfMessage( 'toc' )->plain();
		$this->show = wfMessage( 'showtoc' )->plain();
		$this->hide = wfMessage( 'hidetoc' )->plain();
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
