<?php

class TOCController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function index() {

		$this->tocHeader = wfMessage( 'toc' )->inContentLanguage()->plain();
		$this->show = wfMessage( 'showtoc' )->inContentLanguage()->plain();
		$this->hide = wfMessage( 'hidetoc' )->inContentLanguage()->plain();
	}
}
