<?php
/**
 * Local Sitemap Page Hooks
 */
class LocalSitemapPageHooks {
	const LOCAL_SITEMAP_PAGE_TITLE = 'Local Sitemap';

	private static function isLocalSitemap( $title ) {
		return ( $title
			&& $title->getNamespace() === NS_MAIN
			&& $title->getText() === self::LOCAL_SITEMAP_PAGE_TITLE
		);
	}

	public static function onArticleFromTitle( &$title, &$article ) {
		if ( self::isLocalSitemap( $title ) ) {
			$article = new LocalSitemapPageArticle( $title );
		}

		return true;
	}

	/**
	 * Don't display "talk" button on Local Sitemap
	 */
	public static function onPageHeaderPageTypePrepared( $pageHeaderController, $title ) {
		if ( self::isLocalSitemap( $title ) ) {
			$pageHeaderController->comments = false;
		}
		return true;
	}
}
