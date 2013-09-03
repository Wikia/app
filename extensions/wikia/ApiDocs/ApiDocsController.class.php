<?php

//use \Wikia\Api\Docs;

class ApiDocsController extends WikiaController {
	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		//parent::__construct( 'ApiDocs', 'ApiDocs' );
	}

	public function index() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );
		$this->response->setFormat( 'html' );
		$js = AssetsManager::getInstance()->getURL( 'api_docs_js', $type, false );
		$this->setVal( 'js', $js );
		$css = AssetsManager::getInstance()->getURL( 'api_docs_css', $type, false );
		$this->setVal( 'css', $css );
	}
}
