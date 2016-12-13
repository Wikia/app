<?php
class ResourceLoaderAdEngineSourcePointCSBootstrap extends ResourceLoaderAdEngineSourcePointBase {
	// increase this any time the local files change
	const CACHE_BUSTER = 18;
	const SCRIPT_URL = 'https://api.sourcepoint.com/script/bootstrap?version=1';
	const FALLBACK_SCRIPT_URL = __DIR__ . '/../js/SourcePoint/bootstrap_fallback.js';


	protected function getData() // TODO: remove me, I'm hack because current version of SP has bugs
	{
		return $this->getFallbackDataWhenRequestFails();
	}
}
