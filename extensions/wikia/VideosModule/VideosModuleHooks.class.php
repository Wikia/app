<?php

class VideosModuleHooks {

	static public function onGetRailModuleList(&$modules) {
		wfProfileIn(__METHOD__);

		$app = F::App();
		$pos = $app->wg->User->isAnon() ? 1305 : 1285;


		$modules[$pos] = array('VideosModule', 'index', null);

		wfProfileOut(__METHOD__);

		return true;
	}

	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		// On file pages, this hook can be called mulitple times, so we're going to check if the
		// assets are loaded already before we load them again.
		$app = F::app();

		// Don't do anything if we've already loaded the assets
		if ( $app->wg->VideosModuleAssetsLoaded ) {
			return true;
		}

		// Don't do anything if this is the main page of a site with the VPT enabled
		if ( $app->wg->Title->isMainPage() && $app->wg->EnableVideoPageToolExt ) {
			return true;
		}

		JSMessages::enqueuePackage( 'VideosModule', JSMessages::EXTERNAL );

		$scripts = AssetsManager::getInstance()->getURL( 'videos_module_js' );

		foreach( $scripts as $script ){
			$out->addScript( "<script src='{$script}'></script>" );
		}

		$app->wg->VideosModuleAssetsLoaded = true;

		return true;

	}

}