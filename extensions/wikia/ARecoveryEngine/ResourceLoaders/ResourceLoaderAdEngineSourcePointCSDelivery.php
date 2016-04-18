<?php
class ResourceLoaderAdEngineSourcePointCSDelivery extends ResourceLoaderAdEngineBase {
	const TTL_SCRIPTS = 86400;   // one day for fresh scripts from SourcePoint
	const TTL_GRACE = 3600; // one hour for old scripts (served if we fail to fetch fresh scripts)
	const CACHE_BUSTER = 19;     // increase this any time the local files change
	const REQUEST_TIMEOUT = 30;
	const CS_BOOTSTRAP_VERSION = 1;
	const SCRIPT_DELIVERY_URL = 'https://api.sourcepoint.com/script/cs_recovery';
	const CS_ENDPOINT = '__are';
	const FALLBACK_SCRIPT_BASE_URL = 'project43.wikia.com';

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		$url = self::SCRIPT_DELIVERY_URL.
			'?fmt=js&pub_base=http://'.
			$_SERVER['HTTP_HOST'].'/'.
			self::CS_ENDPOINT.'&pub_adserver=dfp&env=prod';
		return [
			(new ResourceLoaderScript())->setTypeRemote()->setValue($url)
		];
	}

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		global $wgServer;

		$scripts = [
			( new ResourceLoaderScript() )
				->setTypeLocal()
				->setValue(__DIR__ . '/../js/SourcePoint/deliveryScriptFallBack.js')
		];
		$data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];

		$data['script'] = str_replace( self::FALLBACK_SCRIPT_BASE_URL,
										str_replace('http://', '', $wgServer),
										$data['script'] );
		$data['script'] .= '/*Fallback data*/';
		return $data;
	}

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
