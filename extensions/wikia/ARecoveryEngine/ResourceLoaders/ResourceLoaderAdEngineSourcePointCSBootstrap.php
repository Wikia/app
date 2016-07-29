<?php
class ResourceLoaderAdEngineSourcePointCSBootstrap extends ResourceLoaderAdEngineSourcePointBase {
	const TTL_SCRIPTS = 86400;   // one day for fresh scripts from SourcePoint
	const TTL_GRACE = 3600; // one hour for old scripts (served if we fail to fetch fresh scripts)
	const CACHE_BUSTER = 18;     // increase this any time the local files change
	const REQUEST_TIMEOUT = 30;
	const CS_BOOTSTRAP_VERSION = 1;
	const SCRIPT_DELIVERY_URL = 'https://api.sourcepoint.com/script/bootstrap?version=' . self::CS_BOOTSTRAP_VERSION;

	protected $fallbackScriptUrl = __DIR__ . '/../js/SourcePoint/bootStrapFallBack.js';

	protected function getMemcKey() {
		return wfMemcKey('adengine', get_class($this) . __FUNCTION__, static::CACHE_BUSTER);
	}

	/**
	 * Configure scripts that should be loaded into one package
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts() {
		return [
			(new ResourceLoaderScript())->setTypeRemote()->setValue(self::SCRIPT_DELIVERY_URL)
		];
	}
}
