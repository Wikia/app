<?php

class MinimalMainPageHooks {

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return boolean
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		wfProfileIn( __METHOD__ );
		$app = F::app();

		if ( $title->isMainPage() && $app->checkSkin( 'oasis' ) ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			$app->wg->SuppressArticleCategories = true;
			
			// If configured, also hide the ads.
			if( !empty( $app->wg->MinimalMainPageHideAds ) ){
				$app->wg->SuppressAds = true;
				$app->wg->ShowAds = false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
