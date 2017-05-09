<?php

abstract class ResourceLoaderAdEngineSourcePointBase extends ResourceLoaderAdEngineBase {
	// one day for fresh scripts from SourcePoint
	const TTL_SCRIPTS = 86400;
	// one hour for old scripts (served if we fail to fetch fresh scripts)
	const TTL_GRACE = 3600;
	// increase this any time the local files change
	const CACHE_BUSTER = 15;
	const REQUEST_TIMEOUT = 30;
	const FALLBACK_SCRIPT_BASE_URL = 'project43.wikia.com';
	// FALLBACK_SCRIPT_URL should be set in classes extending this class
	const FALLBACK_SCRIPT_URL = null;
	// SCRIPT_URL should be set in classes extending this class
	const SCRIPT_URL = null;

	protected function getMemcKey() {
		return wfSharedMemcKey( 'adengine', get_class( $this ) . __FUNCTION__, static::CACHE_BUSTER );
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
				->setValue( static::FALLBACK_SCRIPT_URL )
		];
		$data = [
			'script' => $this->generateData( $scripts ),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];

		$data['script'] = str_replace( self::FALLBACK_SCRIPT_BASE_URL,
			str_replace( 'http://', '', $wgServer ),
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

		$content = ExternalHttp::get( $url,
			null,
			[
				'headers' => [ 'Authorization' => 'Token ' . $wgSourcePointApiKey ],
				'timeout' => self::REQUEST_TIMEOUT
			]
		);

		if ( !$content ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Failed to fetch SourcePoint script', [ 'url' => $url ] );
		}

		return $content;
	}

	protected function getScripts() {
		return [ ( new ResourceLoaderScript() )->setTypeRemote()->setValue( static::SCRIPT_URL ) ];
	}
}
