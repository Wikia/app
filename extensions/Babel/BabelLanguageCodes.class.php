<?php

/**
 * Handle language code and name processing for the Babel extension, it can also
 * be used by other extension which need such functionality.
 *
 * @ingroup Extensions
 */
class BabelLanguageCodes {
	/**
	 * Takes a language code, and attempt to obtain a better variant of it,
	 * checks the MediaWiki language codes for a match, otherwise checks the
	 * Babel language codes CDB (preferring ISO 639-1 over ISO 639-3).
	 *
	 * @param $code String: Code to try and get a "better" code for.
	 * @return String (language code) or false (invalid language code).
	 */
	public static function getCode( $code ) {
		global $wgLang, $wgBabelLanguageCodesCdb;

		$mediawiki = $wgLang->getLanguageName( $code );
		if ( $mediawiki !== '' ) {
			return $code;
		}

		$codes = CdbReader::open( $wgBabelLanguageCodesCdb );
		return $codes->get( $code );
	}

	/**
	 * Take a code as input, and attempt to find a language name for it in
	 * a a given language, uses the order:
	 *     - CLDR extension
	 *     - MediaWiki language names
	 *     - Babel language names CDB
	 *
	 * @param $code String: Code to get name for.
	 * @param $language String: Code of language to attempt to get name in,
	 *                  defaults to language of code.
	 * @return String (name of language) or false (invalid language code).
	 */
	public static function getName( $code, $language = null ) {
		global $wgBabelLanguageNamesCdb;

		// Get correct code, even though it should already be correct.
		$code = self::getCode( $code );
		if ( $code === false ) {
			return false;
		}

		$language = $language === null ? $code : $language;
		$names = Language::getTranslatedLanguageNames( $language );
		if ( isset( $names[$code] ) ) {
			return $names[ $code ];
		}

		$names = CdbReader::open( $wgBabelLanguageNamesCdb );
		return $names->get( $code );
	}
}
