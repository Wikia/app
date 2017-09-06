<?php

class StaffWelcomePoster {

	const TITLE_MESSAGE_KEY = 'discussions-staff-welcome-title';
	const BODY_MESSAGE_KEY = 'discussions-staff-welcome-post';

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
		$message = $this->getBodyMessage( $transformedLang );
		$title = $this->getTitleMessage( $transformedLang );

		$success = $this->threadCreator->create( $staffId, $siteId, $message, $title );

		return $success;
	}

	private function getStaffFromLang( string $language ): int {
		global $wgStaffWelcomePostLanguageToUserId;
		return $wgStaffWelcomePostLanguageToUserId[$language] ?? $wgStaffWelcomePostLanguageToUserId[self::DEFAULT_LANG];
	}

	private function getBodyMessage( string $language ): string {
		return wfMessage( self::BODY_MESSAGE_KEY )->inLanguage( $language )->plain();
	}

	private function getTitleMessage( string $language ): string {
		return wfMessage( self::TITLE_MESSAGE_KEY )->inLanguage( $language )->plain();
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
