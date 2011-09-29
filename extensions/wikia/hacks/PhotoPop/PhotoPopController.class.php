<?php
/**
 * PhotoPop game
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopController extends WikiaController {
	const CACHE_MANIFEST_PATH = 'wikia.php?controller=PhotoPopAppCacheController&method=serveManifest&format=html';
	
	public function index() {
		global $wgExtensionsPath;
		
		
		$this->appCacheManifestPath = self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";
		//TODO: move to AssetsManager package
		$this->scripts = array(
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/mustache.js"),
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/my.class.js"),
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/observable.js"),
			AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/require.js") . '" data-main="' . $wgExtensionsPath . '/wikia/hacks/PhotoPop/js/main'
		);
		$this->cssLink = AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/css/homescreen.css");
	}
}