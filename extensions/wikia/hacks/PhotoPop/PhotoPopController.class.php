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
		$this->requireJs = AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/lib/require.js");
		$this->dataMain = "{$wgExtensionsPath}/wikia/hacks/PhotoPop/js/main";
		$this->cssLink = AssetsManager::getInstance()->getOneCommonURL("extensions/wikia/hacks/PhotoPop/shared/css/homescreen.css");
	}
}