<?php

class WikiaBarHooks {
	/**
	 * @param string $title name of the page changed.
	 * @param string $text new contents of the page
	 * @return bool return true
	 */
	public static function onMessageCacheReplace($title, $text) {
		$titleParts = explode('/',$title);

		if(
			!empty($titleParts[0]) // base
			&& !empty($titleParts[1]) // vertical
			&& !empty($titleParts[2]) // lang
			&& empty($titleParts[3]) // and no more
			&& $titleParts[0] == 'WikiaBar'
		) {
			$app = F::app();
			$dataMemcKey = $app->wf->SharedMemcKey('WikiaBar', $titleParts[1], $titleParts[2], WikiaBarModel::WIKIABAR_MCACHE_VERSION );
			$app->wg->memc->set($dataMemcKey,null);
		}
		return true;
	}

	public static function onWikiaAssetsPackages(&$out, &$jsPackages, &$scssPackages) {
		$jsPackages[] = 'wikia/WikiaBar/js/WikiaBar.js';
		$scssPackages[] = 'wikia/WikiaBar/css/WikiaBar.scss';
		return true;
	}
}
