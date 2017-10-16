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
		$sitemapPage = new SitemapPageModel();
		if ( $sitemapPage->isSitemapPage( $title ) ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressCommunityHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			$article = new SitemapPageArticle( $title );
		}

		return true;
	}

}
