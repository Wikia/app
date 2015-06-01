<?php
class PageShareHelper {

	const SHARE_DEFAULT_LANGUAGE = 'en';

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
	 *
	 * @param $requestShareLang
	 * @return String language
	 */
	public static function getLangForPageShare( $requestShareLang ) {
		return empty( $requestShareLang ) ? self::SHARE_DEFAULT_LANGUAGE : $requestShareLang;
	}

	public static function isValidShareService( $service, $lang, $isTouchScreen ) {
		// Don't display LINE social network or any other mobile app on desktops
		if ( !$isTouchScreen && !empty( $service['displayOnlyOnTouchDevices'] ) ) {
			return false;
		}

		// filter through include list
		if ( array_key_exists( 'languages:include', $service ) && is_array( $service['languages:include'] ) ) {
			$allowedInLanguage = in_array( $lang, $service['languages:include'] );
		}
		// filter through exclude list
		elseif ( array_key_exists( 'languages:exclude', $service ) && is_array( $service['languages:exclude'] ) ) {
			$allowedInLanguage = !in_array( $lang, $service['languages:exclude'] );
		}
		// if no inclusion or exclusion rules are set, default to true
		else {
			$allowedInLanguage = true;
		}

		return $allowedInLanguage
			&& array_key_exists( 'name', $service )
			&& array_key_exists( 'title', $service )
			&& array_key_exists( 'href', $service );
	}
}
