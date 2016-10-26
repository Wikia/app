<?php

class StaffWelcomePoster {

	const LANG_TO_STAFF_MAP = [
		'de' => 24961680,      // ForestFairy
		'en' => 26339491,      // Mira Laime
		'es' => 12648798,      // Luchofigo85
		'fr' => 26442523,      // Hypsoline
		'it' => 3279487,       // Leviathan_89
		'ja' => 29395778,      // Kuro0222
		'ko' => 24883131,      // Miri-Nae
		'nl' => 4142476,       // Yatalu
		'pl' => 1117661,       // Nanaki
		'pt' => 24005296,      // Macherie ana
		'ru' => 26457441,      // Vlazovskiy
		'vi' => 26041741,      // KhangND
		'zh-hans' => 11909873, // Cal-Boy
		'zh-hant' => 56584     // Ffaarr
	];

	const MESSAGE_KEY = 'discussions-staff-welcome-post';

	const DEFAULT_LANG = 'en';

	const LANGS_TO_TRIM = [ 'pt' ];
	const ZH_HANS_LANGS = [ 'zh', 'zh-hans' ];
	const ZH_HANT_LANGS = [ 'zh-hk', 'zh-tw', 'zh-hant' ];

	private $threadCreator;

	public function __construct() {
		$this->threadCreator = new ThreadCreator();
	}

	public function postMessage( int $siteId, string $language ): bool {
		$transformedLang = $this->getTransformedLang( $language );
		$staffId = $this->getStaffFromLang( $transformedLang );
		$message = $this->getMessage( $transformedLang );

		$success = $this->threadCreator->create( $staffId, $siteId, $message );

		return $success;
	}

	private function getStaffFromLang( string $language ): int {
		return self::LANG_TO_STAFF_MAP[$language] ?? self::LANG_TO_STAFF_MAP[self::DEFAULT_LANG];
	}

	private function getMessage( string $language ): string {
		return wfMessage( self::MESSAGE_KEY )->inLanguage( $language )->plain();
	}

	private function getTransformedLang(string $language ): string {
		$trimmedLang = $this->trimLangIfNecessary( $language );
		return $this->mapLangIfNecessary( $trimmedLang );
	}

	/**
	 * Trim off any regional variants for any languages in the LANGS_TO_TRIM constant above.
	 * @param string $language
	 * @return string
	 */
	private function trimLangIfNecessary(string $language ): string {
		$trimmedLang = substr( $language, 0, 2 );
		return in_array( $trimmedLang, self::LANGS_TO_TRIM ) ? $trimmedLang : $language;
	}

	/**
	 * Map dialects of chinese to either zh-hans or zh-hant
	 * @param string $language
	 * @return string
	 */
	private function mapLangIfNecessary( string $language ): string {
		if ( in_array(  $language, self::ZH_HANS_LANGS ) ) {
			return 'zh-hans';
		} elseif ( in_array( $language, self::ZH_HANT_LANGS ) ) {
			return 'zh-hant';
		}

		return $language;
	}
}
