<?php
/**
 * Local Sitemap Page Hooks
 */
class LocalSitemapPageHooks {

	public static function onArticleFromTitle( &$title, &$article ) {
		if ( LocalSitemapPageHelper::isLocalSitemap( $title ) ) {
			F::app()->wg->SuppressRail = true;
			$article = new LocalSitemapPageArticle( $title );
		}

		return true;
	}

	/**
	 * Don't display "talk" and "create" buttons on Local Sitemap
	 */
	public static function onPageHeaderPageTypePrepared( $pageHeaderController, $title ) {
		if ( LocalSitemapPageHelper::isLocalSitemap( $title ) ) {
			$pageHeaderController->comments = false;
			$pageHeaderController->action = false;
		}
		return true;
	}
}
