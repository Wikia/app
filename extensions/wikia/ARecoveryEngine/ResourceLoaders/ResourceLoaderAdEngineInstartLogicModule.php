<?php

class ResourceLoaderAdEngineInstartLogicModule extends ResourceLoaderAdEngineBase {
	// one day for fresh scripts from IL
	const TTL_SCRIPTS = WikiaResponse::CACHE_STANDARD;
	// one hour for old scripts (served if we fail to fetch fresh scripts)
	const TTL_GRACE = 3600;
	// increase this any time the local files change
	const CACHE_BUSTER = 0;
	const REQUEST_TIMEOUT = 30;
	const LOCAL_FILE_PATH = __DIR__ . '/../js/InstartLogic/code.js';

	protected function getMemcKey() {
		return wfSharedMemcKey( 'adengine', __METHOD__, static::CACHE_BUSTER );
	}

	/**
	 * Configure scripts that should be loaded when cache miss
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		global $wgInstartLogicApiUrl;

		$script = ( new ResourceLoaderScript() )
			->setTypeRemote()
			->setValue( $wgInstartLogicApiUrl );

		return [ $script ];
	}

	/**
	 * Fallback data when request to external script and cache fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		return [
			'script' => $this->getDataFromLocalFile( self::LOCAL_FILE_PATH ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
	}

	/**
	 * @param string $filePath
	 * @return bool|string
	 */
	protected function getDataFromLocalFile( $filePath ) {
		$scripts = [
			( new ResourceLoaderScript() )
				->setTypeLocal()
				->setValue( $filePath )
		];

		return $this->generateData( $scripts );
	}
}
