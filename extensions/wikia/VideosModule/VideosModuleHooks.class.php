<?php

/**
 * Class VideosModuleHooks
 */
class VideosModuleHooks {

	/**
	 * Insert the VideosModule on to the right rail
	 * @param array $modules
	 * @return bool
	 */
	static public function onGetRailModuleList( &$modules ) {
		wfProfileIn(__METHOD__);

		// Use a different position depending on whether the user is logged in
		$app = F::App();
		$pos = $app->wg->User->isAnon() ? 1305 : 1285;

		$modules[$pos] = array('VideosModule', 'index', null);

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Load JS needed to display the VideosModule at the bottom of the article content
	 * @param OutputPage $out
	 * @param string $text
	 * @return bool
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		wfProfileIn(__METHOD__);

		// On file pages, this hook can be called multiple times, so we're going to check if the
		// assets are loaded already before we load them again.
		$app = F::app();

		// Don't do anything if we've already loaded the assets
		if ( $app->wg->VideosModuleAssetsLoaded ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// Don't do anything if this is the main page of a site with the VPT enabled
		if ( $app->wg->Title->isMainPage() && $app->wg->EnableVideoPageToolExt ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		JSMessages::enqueuePackage( 'VideosModule', JSMessages::EXTERNAL );

		$scripts = AssetsManager::getInstance()->getURL( 'videos_module_js' );

		foreach( $scripts as $script ){
			$out->addScript( "<script src='{$script}'></script>" );
		}

		$app->wg->VideosModuleAssetsLoaded = true;

		wfProfileOut(__METHOD__);
		return true;
	}
}