<?php

class ResourceLoaderAdEngineILCode extends ResourceLoaderAdEngineBase {
	// 24h: cache for HTTP downloaded code
	const TTL_SCRIPTS = WikiaResponse::CACHE_STANDARD;
	// 10m: cache for old file-loaded code
	const TTL_GRACE = 600;
	// cache version: increase on any local file change
	const CACHE_BUSTER = 10;
	const REQUEST_TIMEOUT = 30;

	const REMOTE_FILE_URL = 'https://www.nanovisor.io/@p1/client/abd/instart.js?token=e7900721291bb9c31803e60f5441ca1c075df63f';
	const LOCAL_FILE_PATH = __DIR__ . '/../resources/rec/il.js';

	protected function getMemcKey() {
		return wfSharedMemcKey( 'adengine', __METHOD__, static::CACHE_BUSTER );
	}

	/**
	 * Configure scripts that should be loaded when cache miss
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		$script = ( new ResourceLoaderScript() )
			->setTypeRemote()
			->setValue( self::REMOTE_FILE_URL );

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
