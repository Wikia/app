<?php

class ResourceLoaderAdEngineSevenOneMediaModule extends ResourceLoaderModule {
	const TTL_SCRIPTS = 1800; // half an hour -- cache scripts from ad.71i.de for this time
	const TTL_GRACE = 300; // five minutes -- cache last response additionally for this time if we can't download the scripts anymore

	private function generateScript() {

		$random = mt_rand();

		$global = Http::get('http://ad.71i.de/global_js/globalV6.js?' . $random);
		if ($global === false) {
			return false;
		}

		$site = Http::get('http://ad.71i.de/global_js/Sites/wikia.js?' . $random);
		if ($site === false) {
			return false;
		}

		$myCss = file_get_contents(__DIR__ . '/SevenOneMedia/my_ad_integration.css');
		$myJs = file_get_contents(__DIR__ . '/SevenOneMedia/my_ad_integration.js');

		$script = [
			'var SEVENONEMEDIA_GENTIME = ' . json_encode(date('r')) . ';',
			'var SEVENONEMEDIA_CSS = ' . json_encode($myCss) . ';',
			$myJs,
			$site,
			$global,
		];

		return join(PHP_EOL, $script);
	}

	public function getModifiedTime(ResourceLoaderContext $context) {
		return intval(time() / self::TTL_SCRIPTS) * self::TTL_SCRIPTS;
	}

	public function getScript(ResourceLoaderContext $context) {
		global $wgMemc;

		$now = time();

		$memKey = wfSharedMemcKey('adengine', __METHOD__);

		$cached = $wgMemc->get($memKey);
		if (is_array($cached) && $cached['ttl'] > $now) {
			// Cache hit!
			return $cached['value'];
		}

		// Cache miss, need to re-download the scripts
		$generated = $this->generateScript();

		if ($generated === false) {
			// HTTP request didn't work

			if (is_array($cached)) {
				// Oh, we still have the thing cached
				// Let's use the value for the next a few minutes

				$wgMemc->set($memKey, [
					'ttl' => $now + self::TTL_GRACE,
					'value' => $cached['value'],
				]);

				return $cached['value'];
			}

			$error = 'Failed to download SevenOne Media files and had no cached value';
			return 'var SEVENONEMEDIA_ERROR = ' . json_encode($error) . ';';
		}

		$wgMemc->set($memKey, [
			'ttl' => $now + self::TTL_SCRIPTS,
			'value' => $generated,
		]);

		return $generated;
	}

	public function supportsURLLoading() {
		return false;
	}
}
