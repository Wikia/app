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

	// Filled in getAllowedTargetTexts
	private static $targetTexts = null;

	private static function getAllowedTargetTexts() {
		if ( self::$targetTexts !== null ) {
			return self::$targetTexts;
		}

		self::$targetTexts = [];
		foreach ( self::TARGET_LANGS as $lang ) {
			self::$targetTexts[] = Language::getLanguageName( $lang );
		}

		return self::$targetTexts;
	}

	private static function processLink( $targetUrl, $linkText ) {
		global $wgLillyServiceUrl, $wgTitle;

		// wgTitle is null sometimes
		if ( !( $wgTitle instanceof Title ) ) {
			return true;
		}

		$sourceUrl = $wgTitle->getFullURL();

		// Double check the sanity of URLs
		if ( filter_var( $sourceUrl, FILTER_VALIDATE_URL ) === false ||
			filter_var( $targetUrl, FILTER_VALIDATE_URL ) === false
		) {
			return true;
		}

		// Only capture the "in other languages" links, not regular in-article links
		if ( !in_array( trim( $linkText ), self::getAllowedTargetTexts() ) ) {
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

		// Post the connection to Lilly
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
