<?php
/**
 * PhotoPop AppCache manifest generator
 * 
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * $author Jakub Olek
 */
class PhotoPopAppCacheController extends WikiaController {
	const CONTENT_TYPE = 'text/cache-manifest';
	const MANIFEST_VARNISH_CACHE_TIME = 86400;//24h
	
	public function serveManifest(){
		if ( $this->response->getFormat() == WikiaResponse::FORMAT_HTML ) {
			$this->response->setContentType( self::CONTENT_TYPE );
			$this->response->setCacheValidity( self::MANIFEST_VARNISH_CACHE_TIME, self::MANIFEST_VARNISH_CACHE_TIME, array( WikiaResponse::CACHE_TARGET_VARNISH ) );
		}
		
		$files = array();
		$basePath = "extensions/wikia/PhotoPop/";
		$dirs = array('shared/audio', 'shared/images');
		
		foreach( $dirs as $dir ) {
			if ( $handle = opendir( $basePath . $dir ) ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if( $file{0} != '.' ) {
						array_push( $files, "{$basePath}{$dir}/{$file}");
					}
				}
				closedir( $handle );
			}
		}
		
		//not using $this->wg->StyleVersion as that changes always on devbox
		//making it impossible to test the AppCache
		$this->cacheVersion = $this->wg->CacheBuster;
		$this->cacheFiles = implode("\n",$files);
		$this->freshFiles = '*';
	}
}
