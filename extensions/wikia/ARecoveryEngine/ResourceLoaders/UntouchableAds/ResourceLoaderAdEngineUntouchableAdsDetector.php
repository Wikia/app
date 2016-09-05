<?php

class ResourceLoaderUntouchableAdsDetector extends ResourceLoaderAdEngineBase {

	protected $script = __DIR__ . '/../../js/UntouchableAds/detector.js';

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		$scripts = [
			( new ResourceLoaderScript() )
				->setTypeLocal()
				->setValue($this->script)
		];
		return $scripts;
	}

	/**
	 * Fallback data when request to external script fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails() {
		return ["script" => '', "modTime" => '', "ttl" => ''];
	}
}

