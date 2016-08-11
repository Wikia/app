<?php

class LocalSitemapPageHelper {
	const LOCAL_SITEMAP_PAGE_DBKEY = 'Local_Sitemap';

	/**
	 * Whether the page is the one we want to convert to the local sitemap
	 * @param Title $title
	 * @return bool
	 */
	public static function isLocalSitemap( $title ) {
		return ( $title
			&& $title->getNamespace() === NS_MAIN
			&& $title->getDBkey() === self::LOCAL_SITEMAP_PAGE_DBKEY
		);
	}

	public static function getLocalSitemapArticleDBkey() {
		return self::LOCAL_SITEMAP_PAGE_DBKEY;
	}
}
