<?php
/**
 * Sitemap Page Hooks
 */
class SitemapPageHooks {

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return boolean
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		$app = F::app();
		if ( SitemapPage::isSitemapPage( $title ) && $app->checkSkin( 'oasis' ) ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			$article = new SitemapPageArticle( $title );
		}

		return true;
	}

}
