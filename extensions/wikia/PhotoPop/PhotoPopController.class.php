<?php
/**
 * PhotoPop game
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopController extends WikiaController {
	//const CACHE_MANIFEST_PATH = 'wikia.php?controller=PhotoPopAppCache&method=serveManifest&format=html';
	const JS_MESSAGES_PACKAGE = 'PhotoPop';

	/* @var PhotoPopModel */
	private $model;
	private $isJSON;

	public function init(){
		$this->model = (new PhotoPopModel);
		$this->isJSON = $this->response->getFormat() == WikiaResponse::FORMAT_JSON;
	}

	/**
	 * @brief a proxy for other methods that need to output data in the
	 * JSONP format
	 *
	 * @see PhotoPop_jsonp.php
	 */
	public function jsonp(){
		wfProfileIn( __METHOD__ );

		$this->response->setContentType( 'text/javascript' );

		wfProfileOut( __METHOD__ );
	}

	public function index() {
		$this->checkGameAllowed();

		//AppCache disabled for now, it generates more problems than expected
		//$this->response->setVal( 'appCacheManifestPath', self::CACHE_MANIFEST_PATH . "&cb={$this->wg->CacheBuster}" );//$this->wg->StyleVersion

		//Minimize the output size, we don't need all the global variables being exported in MW
		$jsMsg = new JSMessages();
		$jsMsg->enqueuePackage( self::JS_MESSAGES_PACKAGE, JSMessages::INLINE );
		$jsVars = array(
			'wgCacheBuster' => $this->wg->CacheBuster,
			'wgMessages' => $jsMsg->getPackages( array ( self::JS_MESSAGES_PACKAGE ) )
		);

		$this->response->setVal( 'globalVariablesScript', Skin::makeVariablesScript($jsVars) );
		$this->response->setVal( 'scripts', AssetsManager::getInstance()->getGroupCommonURL( 'photopop' ) );
		$this->response->setVal( 'dataMain', $this->wg->ExtensionsPath . '/wikia/PhotoPop/shared/lib/main');
		$this->response->setVal( 'cssLink', AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/PhotoPop/shared/css/homescreen.css" ) );
		$this->response->setVal( 'trackingCode', AnalyticsEngine::track( 'GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW ) );
	}

	public function listGames(){
		wfProfileIn( __METHOD__ );

		$callbackName = $this->request->getVal( 'callback' );


		if ( empty( $callbackName ) && !$this->isJSON ) {
			wfProfileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: callback' );
		}

		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->model->getWikisList( $limit, $batch );

		if ( !$this->isJSON ) {
			$this->response->setVal( 'jsonData', json_encode( $result ) );
			$this->response->setVal( 'callbackName', $callbackName );

			$this->forward( __CLASS__, 'jsonp', false );
		} else {
			$this->response->setVal( 'data', $result );
		}
		wfProfileOut( __METHOD__ );
	}

	public function getData(){
		$this->checkGameAllowed();

		wfProfileIn( __METHOD__ );

		$category = trim( $this->request->getVal( 'category' ) );
		$callbackName = $this->request->getVal( 'callback' );

		if ( empty( $category ) ) {
			wfProfileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: category' );
		}

		if ( empty( $callbackName ) && !$this->isJSON ) {
			wfProfileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: callback' );
		}

		$width = $this->request->getInt( 'width', 480 );
		$height = $this->request->getInt( 'height', 320 );
		$result = $this->model->getGameContents( $category, $width, $height );

		if ( !$this->isJSON ) {
			$this->response->setVal( 'jsonData', json_encode( $result ) );
			$this->response->setVal( 'callbackName', $callbackName );

			$this->forward( __CLASS__, 'jsonp', false );
		} else {
			$this->response->setVal( 'data', $result );
		}
		wfProfileOut( __METHOD__ );
	}

	private function checkGameAllowed(){
		if ( empty ( $this->wg->AllowPhotoPopGame ) ){
			throw new WikiaException('Playing PhotoPop is not allowed from this wiki');
		}
	}
}
