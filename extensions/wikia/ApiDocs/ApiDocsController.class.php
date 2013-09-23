<?php

use Wikia\ApiDocs\Services\ApiDocsServiceFactory;
use Wikia\ApiDocs\Services\IApiDocsService;

class ApiDocsController extends WikiaController {
	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	/**
	 * @var IApiDocsService
	 */
	private $docsService;

	/**
	 *
	 */
	public function __construct() {
		parent::__construct(  );

		$this->docsService = (new ApiDocsServiceFactory)->getApiDocsService();
	}

	/**
	 *
	 */
	public function index() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$css = [ AssetsManager::getInstance()->getSassCommonURL( '//extensions/wikia/ApiDocs/css/ApiDocs.scss', false, ['color-header' => '#004c7f']) ];
		$this->setVal( 'css', $css );

		$licensedService = new LicensedWikisService();
		if ($licensedService->isCommercialUseAllowedForThisWiki()) {
			$js = AssetsManager::getInstance()->getURL( 'api_docs_js', $type, false );
			$this->setVal( 'js', $js );
		} else {
			$this->getResponse()->getView()->setTemplate('ApiDocsController', 'disabled');			
		}
	}

	/**
	 *
	 */
	public function api() {
		$api = $this->getVal("api");

		$apiDoc = $this->docsService->getDoc( $api );

		$this->getResponse()->setFormat("json");
		$this->getResponse()->setData( $apiDoc );
	}

	/**
	 *
	 */
	public function apiList() {
		$docs = $this->docsService->getDocList();

		$thisWikiDocs = [];
		// FIXME - find permanent solution
		foreach ( $this->wg->WikiaApiControllers as $controller => $file ) {
			foreach ( $docs['apis'] as $doc ) {
				if ( $doc['readableName'] . "Controller" == $controller ) {
					if ( class_exists($controller) ) {
						$thisWikiDocs[] = $doc;
						break;
					}
				}
			}
		}
		$docs['apis'] = $thisWikiDocs;

		$this->getResponse()->setFormat("json");
		$this->getResponse()->setData( $docs );
	}
}
