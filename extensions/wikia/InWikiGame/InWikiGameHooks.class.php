<?php
/**
 * InWikiGameHooks
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class InWikiGameHooks {
	/**
	 * @desc Hooks which adds two more javascript file to each page
	 * @param $out
	 * @param $jsPackages
	 * @param $scssPackages
	 * @return bool
	 */
	static public function onWikiaAssetsPackages(&$out, &$jsPackages, &$scssPackages) {
		$jsPackages[] = 'wikia/InWikiGame/js/InWikiGameEntryPointTracker.js';
		return true;
	}
}
