<?php

namespace Email;

/**
 * Class SocialLinksGenerator
 * @package Email
 */
class SocialLinksGenerator {

	const SOCIAL_MEDIA = [
		'en' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/getfandom',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/getfandom',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
			'YouTube' => [
				'url' => 'https://www.youtube.com/channel/UC988qTQImTjO7lUdPfYabgQ',
				'footerIcon' => 'YouTube_Default-2x.png',
				'welcomeIcon' => 'Connect-YouTube.png',
			],
			'Instagram' => [
				'url' => 'https://www.instagram.com/getfandom',
				'footerIcon' => 'Instagram-Default-2x.png',
				'welcomeIcon' => 'Connect-IG.png',
			],
		],
		'zh' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/fandom.zh',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
		],
		'zh-hans' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/fandom.zh',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
		],
		'zh-tw' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/fandom.zh',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
		],
		'fr' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/fandom.fr',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/fandom_fr',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
		],
		'de' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/de.fandom',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/fandom_deutsch',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
			'Instagram' => [
				'url' => 'https://www.instagram.com/de_fandom',
				'footerIcon' => 'Instagram-Default-2x.png',
				'welcomeIcon' => 'Connect-IG.png',
			],
		],
		'it' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/fandom.italy',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/fandom_italy',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
		],
		'ja' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/FandomJP',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/FandomJP',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
		],
		'pl' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/pl.fandom',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/pl_fandom',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
		],
		'br' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/getfandom.br',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/getfandom_br',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
		],
		'ru' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/ru.fandom',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/ru_fandom',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
			'VK' => [
				'url' => 'https://vk.com/ru_fandom',
				'footerIcon' => 'VK-Icon.png',
				'welcomeIcon' => 'Connect-VK.png',
			],
		],
		'es' => [
			'Facebook' => [
				'url' => 'https://www.facebook.com/Fandom.espanol',
				'footerIcon' => 'Facebook-Icon-2x.png',
				'welcomeIcon' => 'Connect-FB.png',
			],
			'Twitter' => [
				'url' => 'https://twitter.com/es_fandom',
				'footerIcon' => 'Twitter-Icon-2x.png',
				'welcomeIcon' => 'Connect-Tw.png',
			],
			'Instagram' => [
				'url' => 'https://www.instagram.com/es_fandom',
				'footerIcon' => 'Instagram-Default-2x.png',
				'welcomeIcon' => 'Connect-IG.png',
			],
		],
	];

	/**
	 * Generates social icon links for welcome email.
	 *
	 * @param $targetLang
	 * @return array
	 */
	public static function generateForWelcomeEmail( $targetLang ) {
		return self::generate( $targetLang, 'welcomeIcon' );
	}

	/**
	 * Generates links for social icons. Default for email footer.
	 *
	 * @param $targetLang - language string
	 * @param $iconKey - key from which icon file name should be taken
	 * @return array - returns array of icons
	 */
	public static function generate( $targetLang, $iconKey = 'footerIcon' ) {
		$lang = empty( self::SOCIAL_MEDIA[$targetLang] ) ? 'en' : $targetLang;
		$socialIcons = self::SOCIAL_MEDIA[$lang];
		$result = [];
		foreach ( $socialIcons as $socialName => $socialIconAttributes ) {
			$result[] = [
				'iconSrc' => ImageHelper::getFileUrl( $socialIconAttributes[$iconKey] ),
				'iconAlt' => $socialName,
				'iconLink' => $socialIconAttributes['url'],
				'iconClass' => strtolower( $socialName ),
			];
		}

		return $result;
	}


}