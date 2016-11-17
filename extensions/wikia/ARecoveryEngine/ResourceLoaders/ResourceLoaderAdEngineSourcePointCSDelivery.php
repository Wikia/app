<?php
class ResourceLoaderAdEngineSourcePointCSDelivery extends ResourceLoaderAdEngineSourcePointBase {
	const CACHE_BUSTER = 22;     // increase this any time the local files change
	const CS_BOOTSTRAP_VERSION = 1;
	const CS_ENDPOINT = '__bre';
	const SCRIPT_URL = 'https://api.sourcepoint.com/script/cs_recovery?fmt=js&pub_adserver=dfp&env=prod';

	protected $fallbackScriptUrl = __DIR__ . '/../js/SourcePoint/deliveryScriptFallBack.js';

	/**
	 * Fetch content from URL
	 * @param $url
	 * @return bool|MWHttpRequest|string
	 */
	protected function fetchRemoteScript( $url ) {
		global $wgSourcePointApiKey;

		$content = Http::get( $url,
			null,
			[
				'headers' => ['Authorization' =>  'Token '.$wgSourcePointApiKey],
				'noProxy' => true,
				'timeout' => self::REQUEST_TIMEOUT
			]
		);

		if (!$content) {
			\Wikia\Logger\WikiaLogger::instance()->warning( 'Failed to fetch SourcePoint script', ['url' => $url] );
		}

		return $content;
	}
}
