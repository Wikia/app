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

	public static function allowRedirect( Title $title ) {
		if ( !self::isSitemapTitle( $title ) || WebRequest::detectProtocol() !== 'http' ) {
			return true;
		}

		$currentHost = parse_url( WikiFactoryLoader::getCurrentRequestUri( $_SERVER, true, true ), PHP_URL_HOST );

		// We only want to deal with plain HTTP versions of the wikia.com domain
		if ( !self::shouldCancelRedirect( $currentHost, $title ) ) {
			return true;
		}

		return false;

	}

	public static function onTestCanonicalRedirect( WebRequest $request, Title $title, OutputPage $output ) {

		if ( self::allowRedirect( $title ) ) {
			return true;
		}

		$output->cancelRedirect();
		$output->disable();

		header( 'X-Sitemaps-Redirect-Cancelled: 1' );
		header( 'Cache-Control: s-maxage=900' );
		header( 'HTTP/1.1 410 Gone' );
		echo '410: Gone';
		exit( 0 );
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
