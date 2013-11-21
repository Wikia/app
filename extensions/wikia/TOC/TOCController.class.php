<?php

class TOCController extends WikiaController {

	public function index() {

		$this->tocHeader = wfMessage( 'toc' )->inContentLanguage()->text();
		$this->show = wfMessage( 'showtoc' )->inContentLanguage()->text();
		$this->hide = wfMessage( 'hidetoc' )->inContentLanguage()->text();
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
