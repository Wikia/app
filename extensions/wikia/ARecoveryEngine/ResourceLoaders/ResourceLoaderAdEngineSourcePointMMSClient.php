<?php

class ResourceLoaderAdEngineSourcePointMMSClient extends ResourceLoaderAdEngineSourcePointBase {
	// increase this any time the local files change
	const CACHE_BUSTER = 0;
	const SCRIPT_URL = 'https://api.sourcepoint.com/script/mms_client?v=1';
	const FALLBACK_SCRIPT_URL = __DIR__ . '/../SourcePoint/mms_client.js';

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		$scripts = [];
		$scripts[] = (new ResourceLoaderScript())->setTypeLocal()->setValue(self::FALLBACK_SCRIPT_URL);
		$data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
		return $data;
	}
}
