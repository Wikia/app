<?php
class PageShareHelper {

	const SHARE_DEFAULT_LANGUAGE = 'en';
	const LINE_NAME = 'line';

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
	 * Language code is sent from the client side. If it's empty, the default (en) is returned.
	 * Both values can be overwritten by ?uselang parameter.
	 *
	 * @param $requestShareLang
	 * @param $useLang
	 * @return String language
	 */
	public static function getLangForPageShare( $requestShareLang, $useLang ) {
		if ( !empty ( $useLang ) ) {
			return $useLang;
		} elseif ( !empty( $requestShareLang ) ) {
			return $requestShareLang;
		} else {
			return self::SHARE_DEFAULT_LANGUAGE;
		}
	}

	public static function isValidShareService( $service, $lang, $isTouchScreen ) {
		// Don't display LINE social network (because it's a mobile app) on desktops
		if ( !$isTouchScreen && $service['name'] === self::LINE_NAME ) {
			return false;
		}
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

		return $allowedInLanguage && array_key_exists( 'href', $service ) && array_key_exists( 'title', $service ) && array_key_exists( 'name', $service );
	}
}
