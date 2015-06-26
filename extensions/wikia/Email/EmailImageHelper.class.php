<?php

namespace Email;

/**
 * Class ImageHelper
 *
 * @package Email
 */
class ImageHelper {

	// Cache icon information for a day
	const ICON_CACHE_TTL = 86400;

	static public $icons = [
		'Wikia',
		'Comics',
		'Games',
		'Movies',
		'Lifestyle',
		'Music',
		'Books',
		'TV',
		'Twitter',
		'Facebook',
		'YouTube',
	];

	/**
	 * Get URL, size and name information about icons created in the newsletter wikia for our emails
	 *
	 * @return array
	 */
	public static function getIconInfo() {
		$info = [];

		foreach ( self::$icons as $name ) {
			$fileInfo = self::getFileInfo( $name );
			$info[$name] = $fileInfo;
		}

		return $info;
	}

	public static function getFileInfo( $name, $fileType = ".gif" ) {
		$info = \WikiaDataAccess::cache(
			self::getFileKey( $name, $fileType ),
			self::ICON_CACHE_TTL,
			function() use ( $name, $fileType ) {
				$file = \GlobalFile::newFromText( $name . $fileType, \Wikia::NEWSLETTER_WIKI_ID );

				return [
					'name'   => $name,
					'url'    => $file->getUrlGenerator()->url(),
					'height' => $file->getHeight(),
					'width'  => $file->getWidth(),
				];
			}
		);

		return $info;
	}

	protected static function getFileKey( $name, $fileType ) {
		return wfSharedMemcKey( 'Email', 'ImageHelper', 'icon', $name ,$fileType );
	}
}
