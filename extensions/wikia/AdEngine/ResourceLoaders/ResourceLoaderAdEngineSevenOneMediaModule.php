<?php

class ResourceLoaderAdEngineSevenOneMediaModule extends ResourceLoaderAdEngineBase {
	const CACHE_BUSTER = 15;    // increase this any time the local files change

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		$scripts = [];

		$cssForHubs = "#ads-outer { max-width: 1030px; width: 1030px; margin: 0 auto; }";
		$myCss = file_get_contents(__DIR__ . '/../SevenOneMedia/my_ad_integration.css');

		$cssAsJSValue = 'var SEVENONEMEDIA_CSS = ' . json_encode($myCss) . ' + '
							. PHP_EOL
							. '(window.wgOasisResponsive ? "" : ' . json_encode($cssForHubs) . ');';

		$scripts[] = (new ResourceLoaderScript())
						->setTypeInline()
						->setValue( $cssAsJSValue );

		$scripts[] = (new ResourceLoaderScript())
						->setTypeLocal()
						->setValue( __DIR__ . '/../SevenOneMedia/my_ad_integration.js' );

		$scripts[] = (new ResourceLoaderScript())
						->setTypeInline()
						->setValue('if (window.myAd && myAd.excludeAds) myAd.excludeAds();');

		$scripts[] = (new ResourceLoaderScript())
						->setTypeRemote()
						->setValue('http://ad.71i.de/global_js/Sites/wikia.js');

		$scripts[] = (new ResourceLoaderScript())
						->setTypeRemote()
						->setValue( 'http://ad.71i.de/global_js/globalV6.js' );

		return $scripts;
	}

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		$now = $this->getCurrentTimestamp();

		$error = 'Failed to download SevenOne Media files and had no cached script';
		$data = [
			'script' => 'var SEVENONEMEDIA_ERROR = ' . json_encode($error) . ';',
			'modTime' => $now,
			'ttl' => $now + self::TTL_GRACE,
		];
		return $data;
	}
}
