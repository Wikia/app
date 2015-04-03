<?php
class PageShareHelper {
	private static function readIcon( $fileName ) {
		$fullName = realpath( __DIR__ . '/icons/' . $fileName . '.svg' );
		if ( is_readable( $fullName ) ) {
			return file_get_contents( $fullName );
		} else {
			return false;
		}
	}

	public static function getIcon( $service ) {
		$icon = self::readIcon( $service );
		if ( !$icon ) {
			$icon = self::readIcon( 'share' );
		}
		return $icon;
	}

	/**
	 * Get language for Page Share service.
	 * For Anon users use the browser language.
	 * For logged in user use user's language.
	 * Both values can be overwritten by ?uselang parameter.
	 *
	 * @return String language
	 */
	public static function getLangForPageShare() {
		global $wgLang, $wgRequest, $wgUser;

		if ( $wgUser->isAnon() ) {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		} else {
			$lang = $wgLang->getCode();
		}
		return $wgRequest->getVal( 'uselang', $lang );
	}

	public static function isValidShareService( $service, $lang ) {
		// filter through include list, default of true
		if ( array_key_exists( 'languages:include', $service ) && is_array( $service['languages:include'] ) ) {
			$allowedInLanguage = in_array( $lang, $service['languages:include'] );
		} else {
			$allowedInLanguage = true;
		}
		// filter through exclude list
		if ( array_key_exists( 'languages:exclude', $service ) && is_array( $service['languages:exclude'] ) ) {
			$allowedInLanguage = $allowedInLanguage && !in_array( $lang, $service['languages:exclude'] );
		}

		return $allowedInLanguage && array_key_exists( 'url', $service ) && array_key_exists( 'title', $service ) && array_key_exists( 'name', $service );
	}
}
