<?php
/**
 * Implements combining dynamic config with static assets
 *
 * @author Władysław Bodzek
 */
class ResourceLoaderAbTestingModule extends ResourceLoaderFileModule {

	protected $abTesting = null;

	protected function getAbTesting() {
		if ( empty( $this->abTesting ) ) {
			$this->abTesting = new AbTesting();
		}
		return $this->abTesting;
	}

	public function getScript(ResourceLoaderContext $context) {
		/** @var $abTesting AbTesting */
		$config = $this->getAbTesting()->getConfigScript();
		$code = parent::getScript($context);

		return "$config;\n$code";
	}

	/**
	 * @return bool
	 */
	public function supportsURLLoading() {
		return false;
	}

	public function getModifiedTime( ResourceLoaderContext $context ) {
		$modifiedTime = parent::getModifiedTime($context);
		$modifiedTime = max($modifiedTime,$this->getAbTesting()->getConfigModifiedTime());
		return $modifiedTime;
	}

}
