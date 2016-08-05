<?php
/**
 * Local Sitemap Page Hooks
 */
class LocalSitemapPageHooks {
	const LOCAL_SITEMAP_PAGE_DBKEY = 'Local_Sitemap';

	/**
	 * Whether the page is the one we want to convert to the local sitemap
	 * @param Title $title
	 * @return bool
	 */
	private static function isLocalSitemap( $title ) {
		return ( $title
			&& $title->getNamespace() === NS_MAIN
			&& $title->getDBkey() === self::LOCAL_SITEMAP_PAGE_DBKEY
		);
	}

	public static function onArticleFromTitle( &$title, &$article ) {
		if ( self::isLocalSitemap( $title ) ) {
			F::app()->wg->SuppressRail = true;
			$article = new LocalSitemapPageArticle( $title );
		}

		return true;
	}

	/**
	 * Don't display "talk" and "create" buttons on Local Sitemap
	 */
	public static function onPageHeaderPageTypePrepared( $pageHeaderController, $title ) {
		if ( self::isLocalSitemap( $title ) ) {
			$pageHeaderController->comments = false;
			$pageHeaderController->action = false;
		}
		return true;
	}
}
