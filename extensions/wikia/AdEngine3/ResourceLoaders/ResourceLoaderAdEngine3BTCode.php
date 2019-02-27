<?php

class ResourceLoaderAdEngine3BTCode extends ResourceLoaderAdEngineBase
{
	// 24h: cache for HTTP downloaded code
	const TTL_SCRIPTS = WikiaResponse::CACHE_STANDARD;
	// 10m: cache for old file-loaded code
	const TTL_GRACE = 600;
	// cache version: increase on any local file change
	const CACHE_BUSTER = 55;
	const REQUEST_TIMEOUT = 30;

	const REMOTE_FILE_URL = 'https://wikia-inc-com.videoplayerhub.com/galleryloader.js';
	const LOCAL_FILE_PATH = __DIR__ . '/../resources/rec/bt.js';

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
		$script = (new ResourceLoaderScript())
			->setTypeRemote()
			->setValue(self::REMOTE_FILE_URL);

		return [$script];
	}

	/**
	 * Fallback data when request to external script and cache fails
	 * @return array ["script" => '', "modTitme" => '', "ttl" => '']
	 */
	protected function getFallbackDataWhenRequestFails()
	{
		return [
			'script' => $this->getDataFromLocalFile(self::LOCAL_FILE_PATH),
			'modTime' => $this->getCurrentTimestamp(),
			'ttl' => self::TTL_GRACE
		];
	}

	/**
	 * @param string $filePath
	 * @return bool|string
	 */
	protected function getDataFromLocalFile($filePath)
	{
		$scripts = [
			(new ResourceLoaderScript())
				->setTypeLocal()
				->setValue($filePath)
		];

		return $this->generateData($scripts);
	}
}
