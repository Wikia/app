<?php

class TimeAgoMessaging {

	const VERSION = 3;
	const TTL = 86400;

	/**
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript() {
		global $wgOut, $wgUser;
		$language = $wgUser->getGlobalPreference( 'language' );
		$timeagolang = self::getLocalizeFileName( $language );
		if ( $timeagolang != null && $timeagolang != '' ) {
			$wgOut->addScriptFile( '/resources/wikia/libraries/jquery/timeago/locales/jquery.timeago.' .
								   $timeagolang . '.js' );
		}
		return true;
	}

	private static function getLocalizeFileName( $language ) {
		$supportedLanguages = [
			'af',
			'ar',
			'bg',
			'ca',
			'cs',
			'de',
			'es',
			'eu',
			'fa',
			'fi',
			'fr',
			'gl',
			'hu',
			'it',
			'ja',
			'ko',
			'mk',
			'nl',
			'pl',
			'pt',
			'ro',
			'ru',
			'sv',
			'tl',
			'uk',
			'vi',
			'zh-hans',
			'zh-hant',
		];
		if ( in_array( $language, $supportedLanguages ) ) {
			return $language;
		}

		//fallback to english
		return '';
	}
}
