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
		$isView = F::app()->wg->Request->getVal('action', 'view') === 'view';
		return $isView && in_array($title->getNamespace(), $namespaces) && $title->exists();
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

	/**
	 * Register <lyricfind> parser hook
	 *
	 * @param Parser $parser parser instance
	 * @return bool true
	 */
	public function onParserFirstCallInit(Parser $parser) {
		$parser->setHook(LyricFindParserController::NAME, 'LyricFindParserController::render');
		return true;
	}

	/**
	 * @param Parser $parser parser
	 * @param string $text parser content
	 */
	public function onParserAfterTidy(Parser $parser, &$text) {
		$text = strtr($text, LyricFindParserController::$markers);
		return true;
	}
}
