<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiHooksHelper {
	
	/**
	 * Returns an array where WF vars names are keys.
	 * Change of these vars should trigger an ET's city_list table update.
	 * @return array  An array with vars names as keys
	 */
	public function getWfVarsTriggeringUpdate() {
		$aWfVarsTriggeringUpdate = [
			'wgServer' => true,
			'wgSitename' => true,
			'wgLanguageCode' => true,
			'wgDBcluster' => true,
		];
		return $aWfVarsTriggeringUpdate;
	}
}
