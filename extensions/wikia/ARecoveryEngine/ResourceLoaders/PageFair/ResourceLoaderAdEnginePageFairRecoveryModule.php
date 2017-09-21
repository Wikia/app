<?php

class ResourceLoaderAdEnginePageFairRecoveryModule extends ResourceLoaderAdEngineBase {

	const LOADER_SCRIPT = __DIR__ . '/../../js/PageFair/loader.js';
	const OBSERVER_SCRIPT = __DIR__ . '/../../js/PageFair/observer.js';
	const WRAPPER_SCRIPT = __DIR__ . '/../../js/PageFair/wrapper.js';
	protected $script = self::WRAPPER_SCRIPT;
	protected $context = null;

	public function __construct() {
		$this->context = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
	}

	protected function getMemcKey() {
		return wfSharedMemcKey( 'adengine', get_class( $this ) . __FUNCTION__ . $this->script, static::CACHE_BUSTER );
	}

	protected function getLocalCacheKey() {
		return get_class( $this ) . $this->script;
	}

	public function getScriptLoader() {
		$this->script = self::LOADER_SCRIPT;
		return $this->getScript( $this->context );
	}

	public function getScriptObserver() {
		$this->script = self::OBSERVER_SCRIPT;
		return $this->getScript( $this->context );
	}
	
	public function getScriptWrapper() {
		$this->script = self::WRAPPER_SCRIPT;
		return $this->getScript( $this->context );
	}
	
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
