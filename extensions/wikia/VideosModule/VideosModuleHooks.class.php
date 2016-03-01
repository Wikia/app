<?php

/**
 * Class VideosModuleHooks
 */
class VideosModuleHooks {

	/**
	 * Load JS needed to display the VideosModule at the bottom of the article content
	 * @param OutputPage $out
	 * @param string $text
	 * @return bool
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		wfProfileIn(__METHOD__);

		// Check if we're on a page where we want to show the Videos Module.
		// If we're not, stop right here.
		if ( !self::canShowVideosModule() ) {
			wfProfileOut(__METHOD__);
			return true;
		}

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

		Wikia::addAssetsToOutput( 'videos_module_js' );

		$app->wg->VideosModuleAssetsLoaded = true;

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Return whether we're on one of the pages where we want to show the Videos Module,
	 * specifically File pages, Article pages, and Main pages
	 * @return bool
	 */
	static public function canShowVideosModule() {
		$wg = F::app()->wg;
		$showableNameSpaces = array_merge( $wg->ContentNamespaces, [ NS_FILE ] );

		if ( $wg->Title->exists()
			 && in_array( $wg->Title->getNamespace(), $showableNameSpaces )
			 && in_array( $wg->request->getVal( 'action' ), [ 'view', null ] )
			 && $wg->request->getVal( 'diff' ) === null
		) {
			return true;
		}
		return false;
	}
}
