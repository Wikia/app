<?php

namespace Email;

/**
 * Class ImageHelper
 *
 * @package Email
 */
class ImageHelper {
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
			$file   = \GlobalFile::newFromText( $name . '.gif', \Wikia::NEWSLETTER_WIKI_ID );
			$width  = $file->getWidth();
			$height = $file->getHeight();
			$url    = $file->getUrlGenerator()->url();

			$info[$name] = [
				'name' => $name,
				'url' => $url,
				'height' => $height,
				'width' => $width,
			];
		}

		return $info;
	}
}
