<?php

class SitemapHooks {

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
		global $wgServer, $wgScriptPath, $wgScript, $wgArticlePath;

		if ( !self::isSitemapTitle( $title ) || WebRequest::detectProtocol() !== 'http' ) {
			return true;
		}

		$currentHost = parse_url( WikiFactoryLoader::getCurrentRequestUri( $_SERVER, true, true ), PHP_URL_HOST );

		// We only want to deal with plain HTTP versions of the wikia.com domain
		if ( !self::shouldCancelRedirect( $currentHost, $title ) ) {
			return true;
		}

		$output->cancelRedirect();

		$request->response()->header( 'X-Sitemaps-Redirect-Cancelled: 1' );

		// Override the wgServer so the sitemap uses host from the current request.
		// This needs to be done because WFL used the address from city_url
		$wgServer = "http://{$currentHost}";
		// Reset script path and related variables on language path wikis
		// so the URLs in the sitemap are correct
		$wgScriptPath = '';
		$wgScript = '/index.php';
		$wgArticlePath = '/wiki/$1';
		return false;
	}

	/**
	 * Used to abort rewriting the title URL parameter for sitemap URLs on
	 * short URL wikis (i.e. those with an article path of /$1 rather than
	 * /wiki/$1).
	 *
	 * @param  string $path
	 * @return bool
	 */
	public static function onWebRequestPathInfoRouterAbort( $path ): bool {
		if ( preg_match( '/^\/(sitemap.+\.xml[.gz]*)$/', $path ) ) {
			return false;
		}
		return true;
	}

	private static function shouldCancelRedirect( $currentHost, Title $targetTitle ): bool {
		global $wgWikiaBaseDomain, $wgFandomBaseDomain;

		$currentHost = wfNormalizeHost( $currentHost );
		$targetUrlParsed = parse_url( wfExpandUrl( $targetTitle->getFullURL(), PROTO_CURRENT ) );
		$targetHost = wfNormalizeHost( $targetUrlParsed['host'] );

		if ( strpos( $currentHost, ".{$wgWikiaBaseDomain}" ) === false ||
			 strpos( $targetHost, ".{$wgFandomBaseDomain}" ) === false
		) {
			return false;
		}

		// Only cancel the redirect if we're redirecting to the fandom.com and potentially
		// the language path version of the current URL
		$wikiaTargetHost = str_replace( ".{$wgFandomBaseDomain}", ".{$wgWikiaBaseDomain}", $targetHost );
		if ( substr_count( $currentHost, '.' ) > 2 ) {
			$langCode = explode( '.', $currentHost )[0];
			if ( strpos( $targetUrlParsed['path'], "/{$langCode}" ) === 0 ) {
				$wikiaTargetHost = "$langCode.$wikiaTargetHost";
			}
		}

		if ( $wikiaTargetHost !== $currentHost ) {
			return false;
		}

		return true;
	}

	private static function isSitemapTitle( Title $title ) {
		return $title->isSpecial( 'Sitemap' );
	}
}
