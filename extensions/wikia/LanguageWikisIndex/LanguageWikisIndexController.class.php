<?php


class LanguageWikisIndexController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LanguageWikisIndex' );
	}

	public function index() {

		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

	}

}
