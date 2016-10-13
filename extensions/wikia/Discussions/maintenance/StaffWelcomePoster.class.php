<?php

class StaffWelcomePoster {

	const LANG_TO_STAFF_MAP = [
		'de' => 24961680, // ForestFairy
		'en' => 26339491, // Mira Laime
		'es' => 12648798, // Luchofigo85
		'fr' => 26442523, // Hypsoline
		'it' => 3279487,  // Leviathan_89
		'ja' => 29395778, // Kuro0222
		'ko' => 24883131, // Miri-Nae
		'nl' => 4142476,  // Yatalu
		'pl' => 1117661,  // Nanaki
		'pt' => 24005296, // Macherie ana
		'ru' => 26457441, // Vlazovskiy
		'vi' => 26041741, // KhangND
		'zh' => 11909873  // Cal-Boy
	];

	const MESSAGE_KEY = 'discussions-staff-welcome-post';

	const DEFAULT_LANG = 'en';

	private $threadCreator;

	public function __construct() {
		$this->threadCreator = new ThreadCreator();
	}

	public function postMessage( string $language, int $siteId ) : bool {
		$staffId = $this->getStaffFromLang( $language );
		$message = $this->getMessage( $language );

		$success = $this->threadCreator->create( $staffId, $siteId,  $message );

		return $success;
	}

	private function getStaffFromLang( string $langCode ) : int {
		$staffId = self::LANG_TO_STAFF_MAP[$this->trimLang( $langCode )];
		return $staffId ?? self::LANG_TO_STAFF_MAP[self::DEFAULT_LANG];
	}

	private function getMessage( string $langCode ) : string {
		return wfMessage( self::MESSAGE_KEY )->inLanguage( $langCode )->plain();
	}

	/**
	 * Trim off any regional variants for the language. Eg, pt-br and pt
	 * should be treated the same, as should all variations of zh.
	 * @param string $lang
	 * @return string
	 */
	private function trimLang( string $lang ) : string {
		return substr( $lang, 0, 2 );
	}
}
