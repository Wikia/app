<?php
/**
 * WikiaMobile AppCache manifest generator
 * 
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileAppCacheController extends WikiaController {
	const CONTENT_TYPE = 'text/cache-manifest';
	const MANIFEST_VARNISH_CACHE_TIME = 86400;//24h
	
	public function serveManifest(){
		if ( $this->response->getFormat() == WikiaResponse::FORMAT_HTML ) {
			$this->response->setContentType( self::CONTENT_TYPE );
			$this->response->setCacheValidity( self::MANIFEST_VARNISH_CACHE_TIME );
		}
		
		$files = AssetsManager::getInstance()->getGroupCommonURL('wikiamobile_js');
		
		//on devbox AM url's contain $wgStyleVersion which changes on each request invalidating the AppCache process
		if ( !$this->wg->DevelEnvironment ) {
			$files = array_unshift( $files, AssetsManager::getInstance()->getSassCommonURL( 'skins/wikiamobile/css/main.scss' ) );
		}
		
		$this->cacheVersion = $this->wg->StyleVersion;
		$this->cacheFiles = str_replace( '//', '/', preg_replace( '/\?cb=[0-9]+/', '', implode( "\n", $files ) ) );
		$this->freshFiles = '*';
	}
}
