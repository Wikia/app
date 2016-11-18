<?php
class ResourceLoaderAdEngineSourcePointCSDelivery extends ResourceLoaderAdEngineSourcePointBase {
	// increase this any time the local files change
	const CACHE_BUSTER = 22;
	const CS_ENDPOINT = '__bre';
	const SCRIPT_URL = 'https://api.sourcepoint.com/script/cs_recovery?fmt=js&pub_adserver=dfp&env=prod';
	const FALLBACK_SCRIPT_URL = __DIR__ . '/../js/SourcePoint/delivery_fallback.js';

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
