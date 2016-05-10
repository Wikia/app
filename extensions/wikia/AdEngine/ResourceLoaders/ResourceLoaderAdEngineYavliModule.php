<?php

class ResourceLoaderAdEngineYavliModule extends ResourceLoaderAdEngineBase {
	const TTL_SCRIPTS = 3600; // one hour for fresh scripts from Yavli
	const TTL_GRACE = 3600; // one hour for old scripts (served if we fail to fetch fresh scripts)
	const CACHE_BUSTER = 0; // increase this any time the local files change
	const REQUEST_TIMEOUT = 30;
	const SCRIPT_DELIVERY_URL = 'http://api.yavli.com/v2/get-ad-server?raw=1';

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
			(new ResourceLoaderScript())->setTypeLocal()->setValue(__DIR__ . '/../Yavli/yavli.js')
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
		global $wgYavliWebsiteId, $wgYavliApiKey;

		$content = ExternalHttp::get( $url,
			null,
			[
				'headers' => [
					'X-WebsiteID' => $wgYavliWebsiteId,
					'X-ApiKey' => $wgYavliApiKey
				],
				'timeout' => self::REQUEST_TIMEOUT
			]
		);

		if (!$content) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Failed to fetch Yavli script', ['url' => $url] );
		}

		return $content;
	}
}