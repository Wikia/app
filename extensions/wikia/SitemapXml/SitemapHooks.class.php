<?php

class SitemapHooks {

	/**
	 * Disable title redirects for sitemaps, as we want to use the original request url rather than Special:Sitemap.
	 */
	public static function onBeforeTitleRedirect( WebRequest $request, Title $title ): bool {
		if ( $title->isSpecial( 'Sitemap' ) ) {
			return false;
		}
		return true;
	}

}
