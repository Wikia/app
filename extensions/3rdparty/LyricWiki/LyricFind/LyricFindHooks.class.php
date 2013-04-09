<?php

class LyricFindHooks extends WikiaObject {

	/**
	 * Checks whether given page is trackable
	 *
	 * @param Title $title page to check
	 * @return bool is trackable?
	 */
	static public function pageIsTrackable(Title $title) {
		$namespaces = F::app()->wg->LyricFindTrackingNamespaces;
		return in_array($title->getNamespace(), $namespaces) && $title->exists();
	}

	/**
	 * Loads page views tracking code
	 *
	 * @param array $jsAssetGroups AssetsManager groups to load
	 * @return bool true
	 */
	public function onOasisSkinAssetGroups(Array &$jsAssetGroups) {
		if (self::pageIsTrackable($this->wg->Title)) {
			$jsAssetGroups[] = 'LyricsFindTracking';
		}

		return true;
	}
}
