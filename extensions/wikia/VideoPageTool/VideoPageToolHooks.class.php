<?php

class VideoPageToolHooks {

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return boolean
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		if ( $title->isMainPage() && $app->checkSkin( 'oasis' ) ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			if ( !$app->wg->request->wasPosted() ) {
				// don't change article object while saving data
				$article = new VideoHomePageArticle( $title );
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @param WikiPage $page
	 * @return bool
	 */
	public static function onArticlePurge( WikiPage &$page ) {
		wfProfileIn( __METHOD__ );

		$title = $page->getTitle();
		if ( $title->getNamespace() == NS_CATEGORY ) {
			$helper = new VideoPageToolHelper();
			$helper->invalidateCacheCategoryData( $title->getText() );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

}
