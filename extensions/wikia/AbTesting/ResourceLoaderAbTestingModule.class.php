<?php
/**
 * Implements combining dynamic config with static assets
 *
 * @author Władysław Bodzek
 */
class ResourceLoaderAbTestingModule extends ResourceLoaderModule {

	protected $abTesting = null;

	protected function getAbTesting() {
		if ( empty( $this->abTesting ) ) {
			$this->abTesting = AbTesting::getInstance();
		}
		return $this->abTesting;
	}

	public function getScript(ResourceLoaderContext $context) {
		return $this->getAbTesting()->getConfigScript();
	}

	/**
	 * @return bool
	 */
	public function supportsURLLoading() {
		return false;
	}

	public function getModifiedTime( ResourceLoaderContext $context ) {
		$modifiedTime = $this->getAbTesting()->getConfigModifiedTime();
		if ( empty($modifiedTime) ) {
			$modifiedTime = 1;
		}
		return $modifiedTime;
	}

}
