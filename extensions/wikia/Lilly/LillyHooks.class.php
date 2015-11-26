<?php

class LillyHooks {
	const LILLY_API_LINKS_V1 = '/links/v1';

	const TARGET_LANGS = [
		'bg',
		'cs',
		'da',
		'de',
		'el',
		'en',
		'es',
		'fr',
		'hr',
		'hu',
		'it',
		'ja',
		'ko',
		'la',
		'nl',
		'no',
		'pl',
		'pt',
		'ro',
		'ru',
		'sl',
		'sr',
		'sv',
		'tr',
		'zh',
		'zh-hk',
	];

	const TARGET_HOSTS = [
		'starwars.wikia.com',
		'bg.starwars.wikia.com',
		'cs.starwars.wikia.com',
		'da.starwars.wikia.com',
		'de.starwars.wikia.com',
		'el.starwars.wikia.com',
		'es.starwars.wikia.com',
		'fr.starwars.wikia.com',
		'hr.starwars.wikia.com',
		'hu.starwars.wikia.com',
		'it.starwars.wikia.com',
		'ja.starwars.wikia.com',
		// alias for hu.starwars.wikia.com:
		'kaminopedia.wikia.com',
		'ko.starwars.wikia.com',
		'la.starwars.wikia.com',
		'nl.starwars.wikia.com',
		'no.starwars.wikia.com',
		'pl.starwars.wikia.com',
		'pt.starwars.wikia.com',
		'ro.starwars.wikia.com',
		'ru.starwars.wikia.com',
		'sl.starwars.wikia.com',
		'sr.starwars.wikia.com',
		'sv.starwars.wikia.com',
		'tr.starwars.wikia.com',
		'zh.starwars.wikia.com',
		// alias for zh.starwars.wikia.com:
		'zh-hk.starwars.wikia.com',
	];

	// Filled in getAllowedLanguageNames
	private static $targetLanguageNames = null;

	private static function getTargetLanguageNames() {
		if ( self::$targetLanguageNames !== null ) {
			return self::$targetLanguageNames;
		}

		self::$targetLanguageNames = [];
		foreach ( self::TARGET_LANGS as $lang ) {
			self::$targetLanguageNames[] = Language::getLanguageName( $lang );
		}

		return self::$targetLanguageNames;
	}

	private static function processLink( $targetUrl, $linkText ) {
		global $wgLillyServiceUrl, $wgTitle, $wgWikiaDatacenter;

		// No calls from Reston
		if ( $wgWikiaDatacenter === WIKIA_DC_RES ) {
			return true;
		}

		// wgTitle is null sometimes
		if ( !( $wgTitle instanceof Title ) ) {
			return true;
		}

		// No links from redirect pages to avoid duplicates
		if ( $wgTitle->isRedirect() ) {
			return true;
		}

		$sourceUrl = $wgTitle->getFullURL();

		// Double check the sanity of URLs
		if ( filter_var( $sourceUrl, FILTER_VALIDATE_URL ) === false ||
			filter_var( $targetUrl, FILTER_VALIDATE_URL ) === false
		) {
			return true;
		}

		// Only capture links in the "in other languages" section, not other cross-wiki links
		// We detect those links by checking their texts which are just the language names
		// as returned by Language::getLanguageName
		if ( !in_array( trim( $linkText ), self::getTargetLanguageNames() ) ) {
			return true;
		}

		$sourceHost = parse_url( $sourceUrl, PHP_URL_HOST );
		$targetHost = parse_url( $targetUrl, PHP_URL_HOST );

		// Don't consider links to the same wiki
		if ( $sourceHost === $targetHost ) {
			return true;
		}

		// Only capture links to the specific wikis
		if ( !in_array( $targetHost, self::TARGET_HOSTS ) ) {
			return true;
		}

		// Post the link to Lilly
		Http::post( $wgLillyServiceUrl . self::LILLY_API_LINKS_V1, [
			'noProxy' => true,
			'postData' => [
				'source' => $sourceUrl,
				'target' => $targetUrl,
			]
		] );
	}

	public static function onLinkerMakeExternalLink( &$url, &$text, &$link, &$attribs ) {
		self::processLink( $url, $text );

		return true;
	}

	public static function onLinkEnd( $dummy, Title $target, array $options, &$html, array &$attribs, &$ret ) {
		if ( $target->isExternal() ) {
			self::processLink( $attribs['href'], $html );
		}

		return true;
	}
}
