<?php

class ResourceLoaderAdEngineSourcePointMMSClient extends ResourceLoaderAdEngineSourcePointBase {
	const CACHE_BUSTER = 0;     // increase this any time the local files change
	const SCRIPT_DETECTION_URL = 'https://api.sourcepoint.com/script/mms_client?v=1';
	const FILE_NAME = 'mms_client.js';
	const DIRECTORY = __DIR__ . '/../SourcePoint/';

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
		$scripts[] = (new ResourceLoaderScript())->setTypeLocal()->setValue(self::DIRECTORY . self::FILE_NAME);
		$data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
		return $data;
	}
}
