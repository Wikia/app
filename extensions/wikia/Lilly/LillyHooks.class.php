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
		global $wgTitle;

		// wgTitle is null sometimes
		if ( !( $wgTitle instanceof Title ) ) {
			return true;
		}

		// No links from redirect pages to avoid duplicates
		if ( $wgTitle->isRedirect() ) {
			return true;
		}

		$sourceUrl = $wgTitle->getFullURL();

		// Only capture links in the "in other languages" section, not other cross-wiki links
		// We detect those links by checking their texts which are just the language names
		// as returned by Language::getLanguageName
		if ( !in_array( trim( $linkText ), self::getTargetLanguageNames() ) ) {
			return true;
		}

		$lilly = new LillyService();
		$lilly->postLink( $sourceUrl, $targetUrl );
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
