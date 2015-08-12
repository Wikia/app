<?php

class ResourceLoaderAdEngineSourcePointModule extends ResourceLoaderModule {
	const TTL_SCRIPTS = 86400;   // one day for fresh scripts from SourcePoint
	const TTL_LOCAL_SCRIPTS = 3600; // one hour for old scripts (served if we fail to fetch fresh scripts)
	const CACHE_BUSTER = 12;     // increase this any time the local files change
	const SCRIPT_DELIVERY_URL = 'https://api.getsentinel.com/script/delivery?delivery=bundle';
	const SCRIPT_RECOVERY_URL = 'https://api.sourcepoint.com/script/recovery?delivery=bundle';

	private $faildToFetchFreshScripts = false;

	private function fetchFromSourcePoint( $url, $fallbackFileLocation = null ) {
		global $wgSourcePointApiKey, $wgDevelEnvironment;

		$content = Http::get( $url,
			null,
			['headers' => ['Authorization' =>  'Token '.$wgSourcePointApiKey],
							'noProxy' => $wgDevelEnvironment ? true : false,
							'timeout' => 15]
		);

		if (!$content) {
			\Wikia\Logger\WikiaLogger::instance()->warning( 'Failed to fetch SourcePoint script', ['url' => $url] );
			$this->faildToFetchFreshScripts = true;
			return file_get_contents( $fallbackFileLocation );
		}

		return $content;
	}

	private function getDeliveryScript() {
		return $this->fetchFromSourcePoint( self::SCRIPT_DELIVERY_URL, __DIR__ . '/SourcePoint/delivery.js' );
	}

	private function getRecoveryScript() {
		return $this->fetchFromSourcePoint( self::SCRIPT_RECOVERY_URL, __DIR__ . '/SourcePoint/recovery.js' );
	}

	private function generateData() {
		$recovery = $this->getRecoveryScript();
		$delivery = $this->getDeliveryScript();

		$scripts = [
			$recovery,
			$delivery,
		];

		return join(PHP_EOL, $scripts);
	}

	private function getCurrentTimestamp() {
		static $now;
		if (!$now) {
			$now = time();
		}
		return $now;
	}

	private function getData() {
		global $wgMemc;
		static $localCache;

		if ($localCache) {
			return $localCache;
		}

		$now = $this->getCurrentTimestamp();

		$memKey = wfSharedMemcKey( 'adengine', __METHOD__, self::CACHE_BUSTER );

		$cached = $wgMemc->get($memKey);

		if ( is_array( $cached ) && $cached['ttl'] > $now ) {
			// Cache hit!
			$localCache = $cached;
			return $cached;
		}

		// Cache miss, need to re-download the scripts
		$generated = $this->generateData();

		// If we fail fetching scripts from SourcePoint, we want to retry in one hour.
		$scriptTTL = $this->faildToFetchFreshScripts ? self::TTL_LOCAL_SCRIPTS : self::TTL_SCRIPTS;

		$data = [
			'script' => $generated,
			'modTime' => $now,
			'ttl' => $now + $scriptTTL
		];

		if ( $generated === $cached['script'] ) {
			$data['modTime'] = $cached['modTime'];
		}

		$wgMemc->set( $memKey, $data );

		$localCache = $data;
		return $data;
	}

	public function getModifiedTime( ResourceLoaderContext $context ) {
		return $this->getData()['modTime'];
	}

	public function getScript( ResourceLoaderContext $context = null ) {
		$data = $this->getData();

		return $data['script'];
	}

	public function supportsURLLoading() {
		return false;
	}
}
