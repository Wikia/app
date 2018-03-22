<?php

class WikiaLanguage {

	/**
	 * Return languages supported by fandom
	 *
	 * @return array
	 */
	public static function getSupportedLanguages() {
		return [
			'de',
			'en',
			'es',
			'fr',
			'it',
			'ja',
			'pl',
			'pt-br',
			'ru',
			'zh',
			'zh-tw'
		];
	}


	/*
	 * get a list of language names available for wiki creation or user preference
	 * @return array
	 */
	public static function getRequestSupportedLanguages() {
		$languages = Language::getLanguageNames();

		foreach ( WikiaLanguage::getNotSupportedLanguages() as $key ) {
			unset( $languages[ $key ] );
		}
		return $languages;
	}

	public static function getNotSupportedLanguages() {
		return [
			'als',
			'an',
			'ang',
			'ast',
			'bar',
			'de2',
			'de-at',
			'de-ch',
			'de-formal',
			'de-weigsbrag',
			'dk',
			'en-gb',
			'eshelp',
			'fihelp',
			'frc',
			'frhelp',
			'ia',
			'ie',
			'ithelp',
			'jahelp',
			'kh',
			'kohelp',
			'kp',
			'ksh',
			'nb',
			'nds',
			'nds-nl',
			'mu',
			'mwl',
			'nlhelp',
			'pdc',
			'pdt',
			'pfl',
			'pthelp',
			'pt-brhelp',
			'ruhelp',
			'simple',
			'tokipona',
			'tp',
			'zh-classical',
			'zh-cn',
			'zh-hans',
			'zh-hant',
			'zh-min-nan',
			'zh-mo',
			'zh-my',
			'zh-sg',
			'zh-yue'
		];
	}
}