<?php
/**
 * PhotoPop game
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopController extends WikiaController {
	const CACHE_MANIFEST_PATH = 'wikia.php?controller=PhotoPopAppCacheController&method=serveManifest&format=html';
	
	private $model;
	
	public function init(){
		$this->model = F::build( 'PhotoPopModel' );
	}
	
	public function index() {
		$this->response->setVal( 'appCacheManifestPath', self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}" );
		
		//TODO: move to AssetsManager package
		$this->response->setVal( 'scripts', array(
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/mustache.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/my.class.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/observable.js" ),
			AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/lib/require.js" ) . '" data-main="' . $this->wg->ExtensionsPath . '/wikia/hacks/PhotoPop/js/main'
		) );
		$this->response->setVal( 'cssLink', AssetsManager::getInstance()->getOneCommonURL( "extensions/wikia/hacks/PhotoPop/shared/css/homescreen.css" ) );
	}
	
	public function listGames(){
		$this->wf->profileIn( __METHOD__ );
		
		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->model->getWikisList( $limit, $batch );
		
		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	public function getData(){
		$this->wf->profileIn( __METHOD__ );
		
		$category = trim( $this->request->getVal( 'category', '' ) );
		
		if ( empty( $category ) ) {
			$this->wf->profileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: category' );
		}
		
		$width = $this->request->getInt( 'width', 480 );
		$height = $this->request->getInt( 'height', 320 );
		$result = $this->model->getGameContents( $category, $width, $height );
		
		$this->response->setVal( 'items', $result );
		
		$this->wf->profileOut( __METHOD__ );
	}
}