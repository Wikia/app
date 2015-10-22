<?php

class LillyHooks {
	const LILLY_API_LINKS_V1 = '/links/v1';

	const TARGET_HOSTS = [
		'starwars.wikia.com',
		'bg.starwars.wikia.com',
		'cs.starwars.wikia.com',
		'da.starwars.wikia.com',
		'el.starwars.wikia.com',
		'es.starwars.wikia.com',
		'ko.starwars.wikia.com',
		'hr.starwars.wikia.com',
		'it.starwars.wikia.com',
		'la.starwars.wikia.com',
		'hu.starwars.wikia.com',
		'nl.starwars.wikia.com',
		'ja.starwars.wikia.com',
		'no.starwars.wikia.com',
		'pt.starwars.wikia.com',
		'ro.starwars.wikia.com',
		'ru.starwars.wikia.com',
		'sl.starwars.wikia.com',
		'sr.starwars.wikia.com',
		'fi.starwars.wikia.com',
		'sv.starwars.wikia.com',
		'tr.starwars.wikia.com',
		'zh-hk.starwars.wikia.com',
	];

	const TARGET_TEXTS = [
		'Български',
		'Česky',
		'Dansk',
		'Deutsch',
		'Ελληνικά',
		'Español',
		'Français',
		'한국어',
		'Hrvatski',
		'Italiano',
		'Latina',
		'Magyar',
		'Nederlands',
		'日本語',
		'Polski',
		'Português',
		'Română',
		'Русский',
		'Slovenščina',
		'Српски / Srpski',
		'Suomi',
		'Svenska',
		'Türkçe',
		// WARNING, There are Unicode LEFT-TO-RIGHT EMBEDDING and
		//          POP DIRECTIONAL FORMATTING chars in those two string:
		// @see http://www.fileformat.info/info/unicode/char/202a/index.htm
		// @see http://www.fileformat.info/info/unicode/char/202c/index.htm
		'‪Norsk (bokmål)‬',
		'‪中文(香港)‬',
	];

	static function onLinkerMakeExternalLink( &$url, &$text, &$link, &$attribs ) {
		global $wgLillyServiceUrl, $wgTitle;

		$sourceUrl = $wgTitle->getFullURL();
		$targetUrl = $url;

		// Double check the sanity of URLs
		if ( filter_var( $sourceUrl, FILTER_VALIDATE_URL ) === false ||
			filter_var( $targetUrl, FILTER_VALIDATE_URL ) === false
		) {
			return true;
		}

		// Only capture the "in other languages" links, not regular in-article links
		if ( !in_array( trim( $text ), self::TARGET_TEXTS ) ) {
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

		return true;
	}
}
