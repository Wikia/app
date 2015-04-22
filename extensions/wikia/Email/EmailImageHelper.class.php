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

	protected static function getFileInfo( $name ) {
		$key = self::getFileKey( $name );
		$memc = \F::app()->wg->Memc;

		$info = $memc->get( $key );
		if ( empty( $info ) ) {
			$file   = \GlobalFile::newFromText( $name . '.gif', \Wikia::NEWSLETTER_WIKI_ID );
			$width  = $file->getWidth();
			$height = $file->getHeight();
			$url    = $file->getUrlGenerator()->url();

			$info = [
				'name'   => $name,
				'url'    => $url,
				'height' => $height,
				'width'  => $width,
			];

			$memc->set( $key, $info, self::ICON_CACHE_TTL );
		}

		return $info;
	}

	protected static function getFileKey( $name ) {
		return wfSharedMemcKey( 'Email', 'ImageHelper', 'icon', $name );
	}
}
