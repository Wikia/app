<?php

class HTTPSSupportHooks {

	const VIGNETTE_IMAGES_HTTP_UPGRADABLE = '#(images|img|static|vignette)(\d+)?\.wikia\.(nocookie\.)?(net|com)#i';

	public static function parserUpgradeVignetteUrls( string &$url ) {
		if ( preg_match( self::VIGNETTE_IMAGES_HTTP_UPGRADABLE, $url ) && strpos( $url, 'http://' ) === 0 ) {
			$url = wfHttpToHttps( $url );
		}
	}

	/**
	 * Hacky support for some non-HTTPS Special:FilePath URLs.
	 *
	 * This will attempt to fix plain HTTP file path URLs in the simplest
	 * cases by converting them to HTTPS Vignette URLs.
	 *
	 * This will not account for non-English translations of Special:FilePath
	 * or language path wikis (which should only have ever been on HTTPS).
	 *
	 * @param  string &$url
	 * @return bool
	 */
	public static function parserUpgradeSpecialFilePathURLs( string &$url ) {
		global $wgWikiaBaseDomainRegex;

		$parts = parse_url( $url );

		if ( empty( $parts['host'] ) || empty( $parts['path'] ) ) {
			return true;
		}

		// We are only supporting legacy uses of Special:FilePath, so hardcoding /wiki/
		// here is necessary, rather than using article path (which could be different on
		// the current wiki). We will also not support translated versions of "Special:FilePath"
		$filePathPrefix = '/wiki/Special:FilePath/';
		$path = urldecode( $parts['path'] );

		if (
			preg_match( "/\\.{$wgWikiaBaseDomainRegex}$/", $parts['host'] )
			&& isset( $parts['scheme'] )
			&& $parts['scheme'] === 'http'
			&& stripos( $path, $filePathPrefix ) === 0
		) {
			$fileName = str_ireplace( $filePathPrefix, '', $path );
			$cityId = WikiFactory::DomainToID( wfNormalizeHost( $parts['host'] ) );

			if ( empty( $cityId ) ) {
				return true;
			}

			$globalFile = GlobalFile::newFromText( $fileName, $cityId );
			if ( $globalFile->exists() ) {
				$url = $globalFile->getUrlGenerator()->url();
			}
		}

		return true;
	}

	/**
	 * Make sure any "external" links to our own wikis that support HTTPS
	 * are using HTTPS instead of HTTP.
	 *
	 * @param  string  &$url
	 * @param  string  &$text
	 * @param  bool    &$link
	 * @param  array   &$attribs
	 * @return boolean
	 */
	public static function onLinkerMakeExternalLink( string &$url, string &$text, bool &$link, array &$attribs ): bool {
		if ( wfHttpsAllowedForURL( $url ) ) {
			$url = wfHttpToHttps( $url );
		}
		return true;
	}

	public static function onInterwikiLoadBeforeCache( &$row ): bool {
		global $wgWikiaBaseDomain;
		if ( !isset( $row['iw_url'] ) || strpos( $row['iw_url'], ".{$wgWikiaBaseDomain}" ) === false ) {
			return true;
		}

		$parts = parse_url( $row['iw_url'] );

		if ( empty( $parts['host'] ) ||
			empty( $parts['path'] ) ||
			$parts['path'] !== '/wiki/$1'
		) {
			return true;
		}

		$cityId = WikiFactory::DomainToID( $parts['host'] );
		if ( empty( $cityId ) || !WikiFactory::isPublic( $cityId ) ) {
			return true;
		}

		$currentUrl = WikiFactory::cityIDtoUrl( $cityId );
		$row['iw_url'] = rtrim( wfHttpToHttps( $currentUrl ), '/' ) . '/wiki/$1';


		return true;
	}

	public static function onBeforeResourceLoaderCSSMinifier( &$style ) {
		global $wgScriptPath;

		if ( empty( $wgScriptPath ) ) {
			return true;
		}

		$style = preg_replace(
			'/(["\'])(\/load\.php\?[^"\']+)(\1)/Um',
			'$1' . $wgScriptPath . '$2$3',
			$style
		);

		$style = preg_replace(
			'/(["\'])(\/[^"\']+ctype=text\/css[^"\']*)(\1)/Um',
			'$1' . $wgScriptPath . '$2$3',
			$style
		);

		return true;
	}
}
