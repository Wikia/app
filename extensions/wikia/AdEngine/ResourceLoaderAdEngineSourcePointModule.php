<?php

class ResourceLoaderAdEngineSourcePointModule extends ResourceLoaderModule {
	const TTL_SCRIPTS = 86400;   // one day
	const CACHE_BUSTER = 11;     // increase this any time the local files change

	private function generateData() {
		$recovery = file_get_contents(__DIR__ . '/SourcePoint/recovery.js');
		$delivery = file_get_contents(__DIR__ . '/SourcePoint/delivery.js');

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

		$memKey = wfSharedMemcKey('adengine', __METHOD__, self::CACHE_BUSTER);

		$cached = $wgMemc->get($memKey);

		if (is_array($cached) && $cached['ttl'] > $now) {
			// Cache hit!
			$localCache = $cached;
			return $cached;
		}

		// Cache miss, need to re-download the scripts
		$generated = $this->generateData();

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

		return $data['script'];
	}

	public function supportsURLLoading() {
		return false;
	}
}
