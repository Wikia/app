<?php

class ResourceLoaderAdEnginePageFairDetectionModule extends ResourceLoaderAdEngineBase {
	const REMOTE_FILE_URL = 'http://asset.pagefair.com/measure.min.js';
	const LOCAL_FILE_PATH = __DIR__ . '/../js/PageFair/measure.min.js';
	const TTL_SCRIPTS = 86400;   // one day for fresh scripts from PageFair
	const TTL_GRACE = 3600; // one hour for old scripts (served if we fail to fetch fresh scripts)
	const CACHE_BUSTER = 1;     // increase this any time the local files change
	const REQUEST_TIMEOUT = 30;

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		$measureScript = ( new ResourceLoaderScript() )
			->setTypeRemote()
			->setValue( self::REMOTE_FILE_URL );

		return [ $measureScript ];
	}

	/**
	 * Fallback data when request to external script fails
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
