<?php

namespace Email;

/**
 * Class EmailMobileBadges
 *
 * @package Email
 */
class EmailMobileBadges {

	static private $badges = [
		'en' => [
			'ios' => 'App-store-badge-en.png',
			'android' => 'Google-play-badge-en.png',
		],
		'de' => [
			'ios' => 'App-store-badge-de.png',
			'android' => 'Google-play-badge-de.png',
		],
		'es' => [
			'ios' => 'App-store-badge-es.png',
			'android' => 'Google-play-badge-es.png',
		],
		'fr' => [
			'ios' => 'App-store-badge-fr.png',
			'android' => 'Google-play-badge-fr.png',
		],
		'it' => [
			'ios' => 'App-store-badge-it.png',
			'android' => 'Google-play-badge-it.png',
		],
		'ja' => [
			'ios' => 'App-store-badge-ja.png',
			'android' => 'Google-play-badge-ja.png',
		],
		'pl' => [
			'ios' => 'App-store-badge-pl.png',
			'android' => 'Google-play-badge-pl.png',
		],
		'pt' => [
			'ios' => 'App-store-badge-pt.png',
			'android' => 'Google-play-badge-pt.png',
		],
		'pt-br' => [
			'ios' => 'App-store-badge-pt-br.png',
			'android' => 'Google-play-badge-pt-br.png',
		],
		'ru' => [
			'ios' => 'App-store-badge-ru.png',
			'android' => 'Google-play-badge-ru.png',
		],
		'zh' => [
			'ios' => 'App-store-badge-zh.png',
			'android' => 'Google-play-badge-zh.png',
		],
		'zh-hans' => [
			'ios' => 'App-store-badge-zh.png',
			'android' => 'Google-play-badge-zh.png',
		],
		'zh-hant' => [
			'ios' => 'App-store-badge-zh-tw.png',
			'android' => 'Google-play-badge-zh-tw.png',
		],
		'zh-tw' => [
			'ios' => 'App-store-badge-zh-tw.png',
			'android' => 'Google-play-badge-zh-tw.png',
		],
	];

	/**
	 * Selects proper mobile badge for given input parameters. If language is not found, fallback to 'en'.
	 *
	 * @param $language - language for badge
	 * @param $platform - platform, currently supported: android, ios
	 * @return string - url to mobile badge
	 */
	public static function getBadgeFor( $language, $platform ) {
		$images =
			empty( self::$badges[$language] ) ? self::$badges['en'] : self::$badges[$language];

		return ImageHelper::getFileUrl( $images[$platform] );
	}
}
