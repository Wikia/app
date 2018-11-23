<?php

class ResourceLoaderAdEngineHMDCode extends ResourceLoaderAdEngineBase {
	// cache version: increase on any local file change
	const CACHE_BUSTER = 30;
	const LOCAL_FILE_PATH = __DIR__ . '/../resources/rec/hmd.js';

	protected function getMemcKey() {
		return wfSharedMemcKey( 'adengine', __METHOD__, static::CACHE_BUSTER );
	}

	/**
	 * Configure scripts that should be loaded when cache miss
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		return [
			( new ResourceLoaderScript() )
			->setTypeLocal()
			->setValue( self::LOCAL_FILE_PATH )
		];
	}

	/**
	 * Fallback data when request to external script and cache fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		return [];
	}
}
