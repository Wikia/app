<?php

class ResourceLoaderAdEngine3HMDCode extends ResourceLoaderAdEngine3Base
{
	// Cache version: increase on any local file change
	const CACHE_BUSTER = 55;
	const LOCAL_FILE_PATH = __DIR__ . '/../resources/rec/hmd.js';

	protected function getMemcKey()
	{
		return wfSharedMemcKey('adengine3', __METHOD__, static::CACHE_BUSTER);
	}

	/**
	 * Configure scripts that should be loaded when cache miss
	 * @return array of ResourceLoaderScript
	 */
	protected function getScripts()
	{
		return [
			(new ResourceLoaderScript())
				->setTypeLocal()
				->setValue(self::LOCAL_FILE_PATH)
		];
	}

	/**
	 * Fallback data when request to external script and cache fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails()
	{
		return [];
	}
}
