<?php
/**
 * PhotoPop game
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopController extends WikiaController {
	const CACHE_MANIFEST_PATH = 'wikia.php?controller=PhotoPopAppCacheController&method=serveManifest&format=html';
	
	private $games = array(
			'trueblood' => array(
				"category" => "Characters",
				"gameName" => "True Blood"
			),
			'glee' => array(
				"category" => "Characters",
				"gameName" => "Glee"
			),
			'lyricwiki' => array(
				"category" => "Albums_released_in_2011",
				"gameName" => "LyricWiki"
			),
			'muppet' => array(
				"category" => "The_Muppets_Characters",
				"gameName" => "Muppets"
			),
			'dexter' => array(
				"category" => "Characters",
				"gameName" => "Dexter"
			),
			'futurama' => array(
				"category" => "Characters",
				"gameName" => "Futurama"
			),
			'trueblood' => array(
				"category" => "Characters",
				"gameName" => "True Blood"
			),
			'twilightsaga' => array(
				"category" => "Twilight_Characters",
				"gameName" => "Twilight Saga"
			)
		);
	
	public function index() {
		$this->appCacheManifestPath = self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";
		//TODO: move to AssetsManager package
		$this->scripts = array(
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/mustache.js"),
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/my.class.js"),
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/observable.js"),
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/require.js") . '" data-main="' . $this->wg->ExtensionsPath . '/wikia/hacks/PhotoPop/js/main'
		);
		$this->cssLink = AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/css/homescreen.css");
	}
	
	public function getData(){
		$this->app->wf->profileIn( __METHOD__ );
		//TODO: move to model
		//TODO: temporary, get the value from WF in final version
		$config = $this->games[$this->wg->DBname];
		$width = $this->getVal('width', 480);
		$category = F::build( 'Category', array( $config['category'] ), 'newFromName' );
		$articles = array();
		
		if ( $category ) {
			$contents = Array();
			$titles = $category->getMembers();
			
			foreach( $titles as $title ) {
				if( $title->getNamespace() == NS_MAIN ){
					$articles[$title->getArticleID()] = array(
						'title' => $title->getText()
					);
				}
			}
			
			$resp = $this->sendRequest( 'ImageServingController', 'index', array( 'ids' => array_keys( $articles ), 'height' => array("w" => 1, "h" => 1), 'width' => $width, 'count' => 1 ) );
			
			$images = $resp->getVal('result');
			
			foreach ( $articles as $id => $item ) {
				if ( !empty( $images[$id][0]['url'] ) ) {
					$articles[$id]['image'] = $images[$id][0]['url'];
				}
			}
		} else {
			$this->app->wf->profileOut( __METHOD__ );
			throw new WikiaException( "No data for '{$categoryName}'" );
		}
		
		$this->articles = $articles;
		
		$this->app->wf->profileOut( __METHOD__ );
	}
}