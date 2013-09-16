<?php

class TOCController extends WikiaController {

	public function index() {

		$this->tocHeader = wfMessage( 'toc-header' )->plain();
		$this->show = wfMessage( 'toc-show' )->plain();
		$this->hide = wfMessage( 'toc-hide' )->plain();
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
