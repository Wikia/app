<?php
/**
 * PhotoPop game
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopController extends WikiaController {
	const CACHE_MANIFEST_PATH = 'wikia.php?controller=PhotoPopAppCacheController&method=serveManifest&format=html';
	
	private $model;
	private $isJSON;
	
	public function init(){
		$this->model = F::build( 'PhotoPopModel' );
		$this->isJSON = $this->response->getFormat() == WikiaResponse::FORMAT_JSON;
	}
	
	/**
	 * @brief a proxy for other methods that need to output data in the
	 * JSONP format
	 *
	 * @see PhotoPop_jsonp.php
	 */
	public function jsonp(){
		$this->wf->profileIn( __METHOD__ );
		
		$this->response->setContentType( 'text/javascript' );
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function index() {
		$this->response->setVal( 'appCacheManifestPath', self::CACHE_MANIFEST_PATH . "&cb={$this->wg->CacheBuster}" );//$this->wg->StyleVersion
		
		F::build('JSMessages')->enqueuePackage('PhotoPop', JSMessages::INLINE);
		
		$this->globalVariablesScript = Skin::makeGlobalVariablesScript('');
		
		//TODO: move to AssetsManager package
		$this->response->setVal( 'scripts', array(
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/mustache.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/my.class.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/store.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/observable.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/reqwest.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/classlist.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/wikia.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/require.js" ) . '" data-main="' . $this->wg->ExtensionsPath . '/wikia/hacks/PhotoPop/shared/lib/main'
		) );
		$this->response->setVal( 'cssLink', AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/css/homescreen.css" ) );
	}
	
	public function listGames(){
		$this->wf->profileIn( __METHOD__ );
		
		$callbackName = $this->request->getVal( 'callback' );
		
		
		if ( empty( $callbackName ) && !$this->isJSON ) {
			$this->wf->profileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: callback' );
		}
		
		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->model->getWikisList( $limit, $batch );
		
		$this->response->setVal( 'jsonData', json_encode( $result ) );
		$this->wf->profileOut( __METHOD__ );
		
		if ( !$this->isJSON ) {
			$this->response->setVal( 'callbackName', $callbackName );
			$this->forward( __CLASS__, 'jsonp', false );
		}
	}
	
	public function getData(){
		$this->wf->profileIn( __METHOD__ );
		
		$category = trim( $this->request->getVal( 'category' ) );
		$callbackName = $this->request->getVal( 'callback' );
		
		if ( empty( $category ) ) {
			$this->wf->profileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: category' );
		}
		
		if ( empty( $callbackName ) && !$this->isJSON ) {
			$this->wf->profileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: callback' );
		}
		
		$width = $this->request->getInt( 'width', 480 );
		$height = $this->request->getInt( 'height', 320 );
		$result = $this->model->getGameContents( $category, $width, $height );
		
		$this->response->setVal( 'jsonData', json_encode( $result ) );
		
		$this->wf->profileOut( __METHOD__ );
		
		if ( !$this->isJSON ) {
			$this->response->setVal( 'callbackName', $callbackName );
			$this->forward( __CLASS__, 'jsonp', false );
		}
	}
}