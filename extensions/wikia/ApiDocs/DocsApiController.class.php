<?php

use Wikia\ApiDocs\Services\ApiDocsServiceFactory;
use Wikia\ApiDocs\Services\IApiDocsService;

class DocsApiController extends WikiaController {
	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const DEFAULT_LICENSE_VALUE = "http://creativecommons.org/licenses/by-sa/3.0/";
	const LICENSE_ICONS_URL = 'files/license/cc-by.svg';

	/**
	 * @var IApiDocsService
	 */
	private $docsService;

	/**
	 * @var ApiAccessService
	 */
	protected $accessService;

	/**
	 *
	 */
	public function __construct() {
		parent::__construct(  );
		$this->docsService = (new ApiDocsServiceFactory)->getApiDocsService();
	}

	public function init(){
		parent::init();
		$this->accessService = new ApiAccessService( $this->getRequest() );
	}

	/**
	 *
	 */
	public function index() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$css = [ AssetsManager::getInstance()->getSassCommonURL( '//extensions/wikia/ApiDocs/css/ApiDocs.scss', false, ['color-header' => '#004c7f']) ];
		$this->setVal( 'css', $css );

		$js = AssetsManager::getInstance()->getURL( 'api_docs_js', $type, false );
		$this->setVal( 'js', $js );

		$licensedService = new LicensedWikisService();
		if ($licensedService->isCommercialUseAllowedForThisWiki()) {
			$licenseMessage = $this->app->renderView("ApiDocsController", "licenseMessage", []);
			$this->getResponse()->setVal("licenseMessage", $licenseMessage);
		} else {
			$licenseWarning = $this->app->renderView("ApiDocsController", "licenseWarning", []);
			$this->getResponse()->setVal("licenseWarning", $licenseWarning);
			$this->getResponse()->setVal("bodyData", ' data-disabled="true" ');
		}
	}

	public function licenseMessage() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );
		$this->response->setVal( 'licenseUrl', $this->licenseUrl() );
		$this->response->setVal( 'licenses', $this->getLicenseIconUrls() );
	}

	public function licenseWarning() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );
		$this->response->setVal( 'licenseClasses', $this->getLicenseClassString() );
		$this->response->setVal( 'licenseName', $this->app->wg->RightsText );
		$this->response->setVal( 'licenseUrl', $this->licenseUrl() );
		$this->response->setVal( 'licenses', $this->getLicenseIconUrls() );
	}

	protected function licenseUrl() {
		return empty($this->app->wg->RightsUrl) ? self::DEFAULT_LICENSE_VALUE : $this->app->wg->RightsUrl;
	}

	protected function getLicenseClassString() {
		return strtolower( implode( " ", $this->app->wg->RightsIcons ) );
	}
	
	protected function getLicenseIconUrls() {
		return [
			'cc-by' => AssetsManager::getInstance()->getURL( self::LICENSE_ICONS_URL )
		];
	}

	protected function getApiMethods( $api )
	{
		$apiDoc = $this->docsService->getDoc( $api );
		$controller = $apiDoc['resourcePath'].'ApiController';

		foreach ( $apiDoc[ 'apis' ] as $i => &$apiElem ) {
			if ( !$this->accessService->canUse( $controller, $apiElem[ 'operations' ][ 0 ][ 'nickname' ] ) ) {
				unset ( $apiDoc[ 'apis' ][ $i ] );
			}
		}
		$apiDoc[ 'apis' ]  = array_values( $apiDoc[ 'apis' ] );
		return $apiDoc;
	}

	public function getApi() {
		$api = $this->getVal("name");

		$apiDoc = $this->getApiMethods( $api );
		$this->getResponse()->setFormat("json");
		$this->getResponse()->setData( $apiDoc );
	}

	public function getList() {
		$docs = $this->docsService->getDocList();

		$thisWikiDocs = [];
		foreach ( $this->wg->WikiaApiControllers as $controller => $file ) {
			// If you cannot use controller
			if ( !$this->accessService->canUse( $controller, null ) ) {
				continue;
			}

			foreach ( $docs['apis'] as $doc ) {
				if ( $doc['readableName'] . "ApiController" == $controller ) {
					if ( class_exists($controller) ) {
						//you can use controller, but there are no methods avail
						$apiDoc = $this->getApiMethods( $doc['readableName'] );
						if ( empty( $apiDoc[ 'apis' ] ) ) {
							continue 2;
						}

						$thisWikiDocs[] = $doc;
						break;
					}
				}
			}
		}

		usort( $thisWikiDocs, function ( $a, $b ) {
			return strcasecmp( $a[ 'readableName' ], $b[ 'readableName' ] );
		} );

 		$docs['apis'] = $thisWikiDocs;

		$this->getResponse()->setFormat("json");
		$this->getResponse()->setData( $docs );
	}

}
