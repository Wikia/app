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

	public static function onPageHeaderActionButtonShouldDisplay( \Title $title, bool &$shouldDisplayActionButton ) {

		if ( $title->getBaseText() === 'Local Sitemap' ) {
			$shouldDisplayActionButton = false;
		}

		return true;
	}
}
