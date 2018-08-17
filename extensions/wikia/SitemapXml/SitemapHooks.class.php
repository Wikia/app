<?php

class SitemapHooks {

	protected static function isSitemapTitle( Title $title ) {
		return $title->isSpecial( 'Sitemap' );
	}

	/**
	 * Disable title redirects for sitemaps, as we want to use the original request url rather than Special:Sitemap.
	 */
	public static function onBeforeTitleRedirect( WebRequest $request, Title $title ): bool {
		if ( self::isSitemapTitle( $title ) ) {
			return false;
		}
		return true;
	}

	public static function onTestCanonicalRedirect( WebRequest $request, Title $title, OutputPage $output ) {
		global $wgServer, $wgWikiaBaseDomain, $wgFandomBaseDomain;

		if ( !self::isSitemapTitle( $title ) || WebRequest::detectProtocol() !== 'http' ) {
			return true;
		}

		$currentUri = \WikiFactoryLoader::getCurrentRequestUri( $_SERVER, true, true );
		$currentHost = parse_url( $currentUri, PHP_URL_HOST );

		// We only want to deal with plain HTTP versions of the wikia.com domain
		if ( strpos( $currentHost, ".{$wgWikiaBaseDomain}" ) === false ) {
			return true;
		}

		// Only cancel the redirect if we're redirecting to the fandom.com version of the
		// current URL
		$targetUrl = wfExpandUrl( $title->getFullURL(), PROTO_CURRENT );
		$targetHost = parse_url( $targetUrl, PHP_URL_HOST );
		if ( strpos( $targetHost, ".{$wgFandomBaseDomain}" ) === false ||
			str_replace( ".{$wgFandomBaseDomain}", ".{$wgWikiaBaseDomain}", $targetHost ) !== $currentHost
		) {
			return true;
		}

		$output->cancelRedirect();

		$request->response()->header( 'X-sitemaps-redirect-cancelled: 1' );

		// Override the wgServer so the sitemap uses host from the current request.
		// This needs to be done because WFL used the address from city_url
		$wgServer = "http://{$currentHost}";
		return false;
	}

}
