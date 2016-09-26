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
			'ios' => 'App-store-badge-en.svg',
			'android' => 'Google-play-badge-en.png'
		],
		'de' => [
			'ios' => 'App-store-badge-de.svg',
			'android' => 'Google-play-badge-de.png'
		],
		'es' => [
			'ios' => 'App-store-badge-es.svg',
			'android' => 'Google-play-badge-es.png'
		],
		'fr' => [
			'ios' => 'App-store-badge-fr.svg',
			'android' => 'Google-play-badge-fr.png'
		],
		'it' => [
			'ios' => 'App-store-badge-it.svg',
			'android' => 'Google-play-badge-it.png'
		],
		'ja' => [
			'ios' => 'App-store-badge-ja.svg',
			'android' => 'Google-play-badge-ja.png'
		],
		'pl' => [
			'ios' => 'App-store-badge-pl.svg',
			'android' => 'Google-play-badge-pl.png'
		],
		'pt' => [
			'ios' => 'App-store-badge-pt.svg',
			'android' => 'Google-play-badge-pt.png'
		],
		'pt-br' => [
			'ios' => 'App-store-badge-pt-br.svg',
			'android' => 'Google-play-badge-pt-br.png'
		],
		'ru' => [
			'ios' => 'App-store-badge-ru.svg',
			'android' => 'Google-play-badge-ru.png'
		],
		'zh' => [
			'ios' => 'App-store-badge-zh.svg',
			'android' => 'Google-play-badge-zh.png'
		],
		'zh-hans' => [
			'ios' => 'App-store-badge-zh.svg',
			'android' => 'Google-play-badge-zh.png'
		],
		'zh-hant' => [
			'ios' => 'App-store-badge-zh-tw.svg',
			'android' => 'Google-play-badge-zh-tw.png'
		],
		'zh-tw' => [
			'ios' => 'App-store-badge-zh-tw.svg',
			'android' => 'Google-play-badge-zh-tw.png'
		]
	];

	/**
	 * Selects proper mobile badge for given input parameters.
	 *
	 * @param $language - language for badge
	 * @param $platform - platform, currently supported: android, ios
	 * @return string - url to mobile badge
	 */
	public static function getBadgeFor( $language, $platform ) {
		$badges = EmailMobileBadges::$badges[$language][$platform];

		if ( !$badges ) {
			$badges = EmailMobileBadges::$badges['en'][$platform];
		}

		return ImageHelper::getFileUrl( EmailMobileBadges::$badges[$language][$platform] );
	}
}