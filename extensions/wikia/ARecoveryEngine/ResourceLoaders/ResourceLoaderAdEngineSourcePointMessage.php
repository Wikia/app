<?php

class ResourceLoaderAdEngineSourcePointMessage extends ResourceLoaderAdEngineSourcePointBase {
	// increase this any time the local files change
	const CACHE_BUSTER = 0;
	const SCRIPT_URL = 'https://api.sourcepoint.com/script/msg?v=1';
	const FALLBACK_SCRIPT_URL = __DIR__ . '/../SourcePoint/msg.js';

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		$scripts = [];
		$scripts[] = (new ResourceLoaderScript())->setTypeLocal()->setValue(self::FALLBACK_SCRIPT_URL);
		return $data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
	}
}
