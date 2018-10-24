<?php


class LanguageWikisIndexController extends \WikiaSpecialPageController {

	const INDEX_PAGE_TITLE = '/language-wikis';

	public function __construct() {
		parent::__construct( 'LanguageWikisIndex' );
	}

	public function index() {
		global $wgRequest;

		$url = $wgRequest->getRequestURL();
		if ( $url == '/' ) {

			$this->skipRendering();
			$this->response->redirect( self::INDEX_PAGE_TITLE );
			return;
		}


		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

	}

}
