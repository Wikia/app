<?php

//use \Wikia\Api\Docs;

class ApiDocsController extends WikiaController {
	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $swagger;
	private $docsService;

	public function __construct() {
		//parent::__construct( 'ApiDocs', 'ApiDocs' );
		global $IP;
		$this->swagger = \Swagger\Swagger::discover( $IP . "/includes/wikia/api/" );
		$this->docsService = new \Wikia\ApiDocs\Services\ApiDocsService( $this->swagger, function( $x ) { return "/wikia.php?controller=ApiDocs&method=api&api=" . $x; } );
	}

	public function index() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$js = AssetsManager::getInstance()->getURL( 'api_docs_js', $type, false );
		$this->setVal( 'js', $js );
		$css = AssetsManager::getInstance()->getURL( 'api_docs_css', $type, false );
		$this->setVal( 'css', $css );
	}

	public function api() {
		$api = $this->getVal("api");

		$apiDoc = $this->docsService->getDoc( $api );

		$this->getResponse()->setFormat("json");
		$this->getResponse()->setData( $apiDoc );
	}

	public function apiList() {

		$this->getResponse()->setFormat("json");
		$this->getResponse()->setData( $this->docsService->getDocList() );
	}
}
