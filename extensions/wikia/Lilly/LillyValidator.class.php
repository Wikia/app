<?php

class LillyValidator {
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

	private function getTargetLanguageNames() {
		static $targetLanguageNames;

		if ( $targetLanguageNames !== null ) {
			return $targetLanguageNames;
		}

		$targetLanguageNames = [];
		foreach ( self::TARGET_LANGS as $lang ) {
			$targetLanguageNames[] = Language::getLanguageName( $lang );
		}

		return $targetLanguageNames;
	}

	public function validateLinkText( $linkText ) {
		// Only capture links in the "in other languages" section, not other cross-wiki links
		// We detect those links by checking their texts which are just the language names
		// as returned by Language::getLanguageName
		return in_array( trim( $linkText ), self::getTargetLanguageNames() );
	}

	public function validateTitle( $title ) {
		// wgTitle is null sometimes
		if ( !( $title instanceof Title ) ) {
			return false;
		}

		// No links from redirect pages to avoid duplicates
		if ( $title->isRedirect() ) {
			return false;
		}

		return true;
	}
}
