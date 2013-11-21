<?php

class TOCController extends WikiaController {

	public function index() {

		$this->tocHeader = wfMessage( 'toc' )->inContentLanguage()->plain();
		$this->show = wfMessage( 'showtoc' )->inContentLanguage()->plain();
		$this->hide = wfMessage( 'hidetoc' )->inContentLanguage()->plain();
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
