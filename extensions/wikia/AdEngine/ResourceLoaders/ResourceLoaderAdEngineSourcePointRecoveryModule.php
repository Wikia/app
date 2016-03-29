<?php

class ResourceLoaderAdEngineSourcePointRecoveryModule extends ResourceLoaderAdEngineBase {
	const TTL_SCRIPTS = 86400;   // one day for fresh scripts from SourcePoint
	const TTL_GRACE = 3600; // one hour for old scripts (served if we fail to fetch fresh scripts)
	const CACHE_BUSTER = 15;     // increase this any time the local files change
	const REQUEST_TIMEOUT = 30;
	const SCRIPT_DELIVERY_URL = 'https://api.sourcepoint.com/script/delivery?delivery=bundle';

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		return [
			(new ResourceLoaderScript())->setTypeRemote()->setValue(self::SCRIPT_DELIVERY_URL)
		];
	}

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		$scripts = [
			(new ResourceLoaderScript())->setTypeLocal()->setValue(__DIR__ . '/../SourcePoint/delivery.js')
		];
		$data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
		return $data;
	}

	/**
	 * Fetch content from URL
	 * @param $url
	 * @return bool|MWHttpRequest|string
	 */
	protected function fetchRemoteScript( $url ) {
		global $wgSourcePointApiKey;

		$content = ExternalHttp::get( $url,
			null,
			[
				'headers' => ['Authorization' =>  'Token '.$wgSourcePointApiKey],
				'timeout' => self::REQUEST_TIMEOUT
			]
		);

		if (!$content) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Failed to fetch SourcePoint script', ['url' => $url] );
		}

		return $content;
	}
}
