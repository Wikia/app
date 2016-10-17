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
		'FandomTopBar' => [
			'name' => 'Top-Bar-2x',
			'extension' => 'png'
		],
		'FandomLogoHeader' => [
			'name' => 'Hero-Logo-2x',
			'extension' => 'png'
		],
		'FandomLogoFooter' => [
			'name' => 'Footer-logo-2x',
			'extension' => 'png'
		],
		'Wikia' => [
			'name' => 'Wikia',
			'extension' => 'gif'
		],
		'Twitter' => [
			'name' => 'Twitter-Icon-2x',
			'extension' => 'png'
		],
		'Facebook' => [
			'name' => 'Facebook-Icon-2x',
			'extension' => 'png'
		],
		'YouTube' => [
			'name' => 'YouTube_Default-2x',
			'extension' => 'png'
		],
		'VK' => [
			'name' => 'VK-Icon',
			'extension' => 'png'
		],
		'Instagram' => [
			'name' => 'Instagram-Default-2x',
			'extension' => 'png'
		],
		'Welcome-Facebook' => [
			'name' => 'Connect-FB',
			'extension' => 'png'
		],
		'Welcome-Twitter' => [
			'name' => 'Connect-Tw',
			'extension' => 'png'
		],
		'Welcome-YouTube' => [
			'name' => 'Connect-YouTube',
			'extension' => 'png'
		],
		'Welcome-Instagram' => [
			'name' => 'Connect-IG',
			'extension' => 'png'
		],
		'Welcome-VK' => [
			'name' => 'Connect-VK',
			'extension' => 'png'
		]
	];

	/**
	 * Get URL, size and name information about icons created in the newsletter wikia for our emails
	 *
	 * @return array
	 */
	public static function getIconInfo() {
		$info = [];

		foreach ( self::$icons as $key => $icon ) {
			$fileInfo = self::getFileInfo( $icon['name'] . '.' . $icon['extension'] );
			$info[$key] = $fileInfo;
		}

		return $info;
	}

	public static function getFileUrl( $name ) {
		$fileInfo = self::getFileInfo( $name );
		return $fileInfo['url'];
	}

	public static function getFileInfo( $name ) {
		$info = \WikiaDataAccess::cache(
			self::getFileKey( $name ),
			self::ICON_CACHE_TTL,
			function() use ( $name ) {
				$file = \GlobalFile::newFromText( $name, \Wikia::NEWSLETTER_WIKI_ID );

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

	protected static function getFileKey( $name ) {
		return wfSharedMemcKey( 'Email', 'ImageHelper', 'icon', $name );
	}
}
