<?php

class ResourceLoaderAdEngineSevenOneMediaModule extends ResourceLoaderModule {
	const TTL_SCRIPTS = 1800; // half an hour -- cache scripts from ad.71i.de for this time
	const TTL_GRACE = 300;    // five minutes -- cache last response additionally for this time if we can't download the scripts anymore
	const CACHE_BUSTER = 7;   // increase this any time the local files change

	private function generateData() {
		$global = Http::get('http://ad.71i.de/global_js/globalV6.js');
		if ($global === false) {
			return false;
		}

		$site = Http::get('http://ad.71i.de/global_js/Sites/wikia.js');
		if ($site === false) {
			return false;
		}

		$myCss = file_get_contents(__DIR__ . '/SevenOneMedia/my_ad_integration.css');
		$myJs = file_get_contents(__DIR__ . '/SevenOneMedia/my_ad_integration.js');
		$excludeAds = 'if (window.myAd && myAd.excludeAds) myAd.excludeAds();';
		$cssForHubs = "#ads-outer { max-width: 1030px; width: 1030px; margin: 0 auto; }";

		// $myCss = CSSMin::minify($myCss);

		$script = [
			'var SEVENONEMEDIA_CSS = ' . json_encode($myCss) . ' + ',
			'(window.wgOasisResponsive ? "" : ' . json_encode($cssForHubs) . ');',
			$myJs,
			$excludeAds,
			$site,
			$global,
		];

		return join(PHP_EOL, $script);
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

		$memKey = wfSharedMemcKey('adengine', __METHOD__, self::CACHE_BUSTER);

		$cached = $wgMemc->get($memKey);
		if (is_array($cached) && $cached['ttl'] > $now) {
			// Cache hit!
			$localCache = $cached;
			return $cached;
		}

		// Cache miss, need to re-download the scripts
		$generated = $this->generateData();

		if ($generated === false) {
			// HTTP request didn't work

			if (is_array($cached)) {
				// Oh, we still have the thing cached
				// Let's use the script for the next a few minutes

				$cached['ttl'] = $now + self::TTL_GRACE;
				$wgMemc->set($memKey, $cached);

				$localCache = $cached;
				return $cached;
			}

			$error = 'Failed to download SevenOne Media files and had no cached script';
			$data = [
				'script' => 'var SEVENONEMEDIA_ERROR = ' . json_encode($error) . ';',
				'modTime' => $now,
				'ttl' => $now + self::TTL_GRACE,
			];
			$wgMemc->set($memKey, $data);

			$localCache = $data;
			return $data;
		}

		$data = [
			'script' => $generated,
			'modTime' => $now,
			'ttl' => $now + self::TTL_SCRIPTS,
		];

		if ($generated === $cached['script']) {
			$data['modTime'] = $cached['modTime'];
		}

		$wgMemc->set($memKey, $data);

		$localCache = $data;
		return $data;
	}

	public function getModifiedTime(ResourceLoaderContext $context) {
		return $this->getData()['modTime'];
	}

	public function getScript(ResourceLoaderContext $context) {
		$data = $this->getData();
		$script = [
			'var SEVENONEMEDIA_MODTIME = ' . json_encode(date('r', $data['modTime'])) . ';',
			$data['script'],
		];
		return join(PHP_EOL, $script);
	}

	public function supportsURLLoading() {
		return false;
	}
}
