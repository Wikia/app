<?php
class PageFairBootstrapCode {
	private $resourceLoader = null;

	public function __construct() {
		$this->resourceLoader = new ResourceLoaderAdEnginePageFairRecoveryModule();
	}

	public function getHeadCode() {
		return $this->resourceLoader->getScriptObserver();
	}

	public function getTopBodyCode() {
		return $this->resourceLoader->getScriptWrapper();
	}

	public function getBottomBodyCode() {
		return $this->resourceLoader->getScriptLoader();
	}
}
