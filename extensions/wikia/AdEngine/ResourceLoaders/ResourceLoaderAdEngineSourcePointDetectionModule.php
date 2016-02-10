<?php

class ResourceLoaderAdEngineSourcePointDetectionModule extends ResourceLoaderAdEngineSourcePointRecoveryModule {
	const CACHE_BUSTER = 3;     // increase this any time the local files change
	const SCRIPT_DETECTION_URL = 'https://api.sourcepoint.com/script/detection?delivery=bundle';

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		$scripts = [];
		$scripts[] = (new ResourceLoaderScript())->setTypeRemote()->setValue(self::SCRIPT_DETECTION_URL);
		return $scripts;
	}

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		$scripts = [];
		$scripts[] = (new ResourceLoaderScript())->setTypeLocal()->setValue(__DIR__ . '/../SourcePoint/detection.js');
		$data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
		return $data;
	}
}
