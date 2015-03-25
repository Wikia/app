<?php
class IconFileNotFoundException extends WikiaBaseException {}

class PageShareHelper {
	private static function readIcon( $fileName ) {
		$fullName = realpath( __DIR__ . '/icons/' . $fileName . '.svg' );
		if ( is_readable( $fullName ) ) {
			return file_get_contents( $fullName );
		} else {
			throw new IconFileNotFoundException("Icon not found inside PageShare: icons/{$fileName}.svg");
		}
	}

	public static function getIcon( $service ) {
		switch ($service) {
			case 'facebook':
				return self::readIcon('facebook');
			case 'googleplus':
				return self::readIcon('googleplus');
			case 'twitter':
				return self::readIcon('twitter');
			case 'reddit':
				return self::readIcon('reddit');
			case 'tumblr':
				return self::readIcon('tumblr');
			case 'vkontakte':
				return self::readIcon('vkontakte');
			case 'qzone':
				return self::readIcon('qzone');
			default:
				// default share icon
				return self::readIcon('share');
		}
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
