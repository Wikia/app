<?php

namespace Email;

use Http;

/**
 * Class MobileApplicationsLinksGenerator
 * @package Email
 */
class MobileApplicationsLinksGenerator {

	const MOBILE_APPLICATIONS_ENDPOINT = 'https://services.wikia.com/mobile-applications/platform/android';

	const RELEASE_KEYWORD = '%release%';

	const WIKIA_APP_STORE_URL = 'https://itunes.apple.com/%s/developer/wikia-inc./id422467077';

	const APPLICATION_APP_STORE_URL = 'https://itunes.apple.com/%s/app/id' . self::RELEASE_KEYWORD;

	const WIKIA_GOOGLE_PLAY_URL = 'https://play.google.com/store/apps/developer?hl=%s&id=Fandom+powered+by+Wikia';

	const APPLICATION_GOOGLE_PLAY_URL = 'https://play.google.com/store/apps/details?hl=%s&id=' .
	                                    self::RELEASE_KEYWORD;

	const ANDROID_PLATFORM = 'android';

	const IOS_PLATFORM = 'ios';

	const MOBILE_APPLICATIONS_LINKS_EVICTION_TIME = 24 * 60 * 60; // 24h

	static private $appStoreLanguagesMapping = [
		'en' => 'us',
		'zh' => 'cn',
		'zh-hans' => 'cn',
		'zh-tw' => 'tw',
		'fr' => 'fr',
		'de' => 'de',
		'it' => 'it',
		'ja' => 'jp',
		'pl' => 'pl',
		'pt' => 'pt',
		'pt-br' => 'br',
		'ru' => 'ru',
		'es' => 'es',
	];

	private $language;

	/**
	 * MobileApplicationsLinksGenerator constructor.
	 *
	 * @param string $language - language for localized store
	 */
	public function __construct( $language ) {
		$this->language = $language;
	}

	/**
	 * Generates links for mobile applications for current wiki.
	 *
	 * @return array - currently will contains 2 elements, link for app store and google play
	 */
	public function generate() {
		global $wgMemc;

		$mobileApplicationsLinks =
			$wgMemc->get( $this->createCacheKeyForMobileApplicationsLinks() );

		if ( is_bool( $mobileApplicationsLinks ) ) {
			$mobileApplicationsLinks = [];
			$response = $this->fetchMobileApplicationsDetails();

			if ( $response && $this->applicationsExistIn( $response ) ) {
				$mobileApplications = json_decode( $response, true );
				$mobileApplicationsLinks = $this->traverseThrough( $mobileApplications );
			}

			$mobileApplicationsLinks =
				$this->fillWithWikiaAccountLinksIfEmpty( $mobileApplicationsLinks );

			// Even if response is not valid (for example there are some difficulties with mobile applications service)
			// result will be cached to prevent too long delays in email generation
			$wgMemc->set( $this->createCacheKeyForMobileApplicationsLinks(),
				$mobileApplicationsLinks, time() + self::MOBILE_APPLICATIONS_LINKS_EVICTION_TIME );
		}

		return $this->localizeLinks( $mobileApplicationsLinks );
	}

	private function createCacheKeyForMobileApplicationsLinks() {
		return wfMemcKey( 'mobileApplicationsLinks' );
	}

	/**
	 * @return string or boolean (because of Http::request)
	 */
	private function fetchMobileApplicationsDetails() {
		// currently it does not matter if Android or iOS value is added, data is returned for both Android and iOS
		return Http::request( 'GET', self::MOBILE_APPLICATIONS_ENDPOINT );
	}

	/**
	 * @param string response - raw, not parsed response
	 *
	 * @return boolean
	 */
	private function applicationsExistIn( $response ) {
		return strpos( $response, 'wikia_id":' . \F::app()->wg->CityId ) !== false;
	}

	/**
	 * @param array $mobileApplications - array containing information about mobile applications
	 * @return array - containing mobile applications links
	 */
	private function traverseThrough( $mobileApplications ) {
		$mobileApplicationsLinks = [];
		$siteId = \F::app()->wg->CityId;

		foreach ( $mobileApplications['apps'] as $app ) {
			foreach ( $app['languages'] as $appLanguage ) {
				if ( $appLanguage['wikia_id'] == $siteId ) {
					$mobileApplicationsLinks = $this->populateMobileApplicationsLinks( $app );
					break;
				}
			}

			if ( !empty( $mobileApplicationsLinks ) ) {
				break;
			}
		}

		return $mobileApplicationsLinks;
	}

	private function populateMobileApplicationsLinks( $app ) {
		$mobileApplicationsLinks = [];

		if ( $app['android_release'] ) {
			$mobileApplicationsLinks[self::ANDROID_PLATFORM] =
				$this->generateUrlForWikiaApplicationOnGooglePlay( $app['android_release'] );
		}
		if ( $app['ios_release'] ) {
			$mobileApplicationsLinks[self::IOS_PLATFORM] =
				$this->generateUrlForWikiaApplicationOnAppStore( $app['ios_release'] );
		}

		return $mobileApplicationsLinks;
	}

	private function generateUrlForWikiaApplicationOnGooglePlay( $release ) {
		return str_replace( self::RELEASE_KEYWORD, $release, self::APPLICATION_GOOGLE_PLAY_URL );
	}

	private function generateUrlForWikiaApplicationOnAppStore( $release ) {
		return str_replace( self::RELEASE_KEYWORD, $release, self::APPLICATION_APP_STORE_URL );
	}

	/**
	 * Fills array with wikia mobile application store link if application was not found
	 *
	 * @param array $mobileApplicationsLinks
	 * @return array with links to app store and google play
	 */
	private function fillWithWikiaAccountLinksIfEmpty( $mobileApplicationsLinks ) {
		if ( empty ( $mobileApplicationsLinks[self::ANDROID_PLATFORM] ) ) {
			$mobileApplicationsLinks[self::ANDROID_PLATFORM] = self::WIKIA_GOOGLE_PLAY_URL;
		}

		if ( empty( $mobileApplicationsLinks[self::IOS_PLATFORM] ) ) {
			$mobileApplicationsLinks[self::IOS_PLATFORM] = self::WIKIA_APP_STORE_URL;
		}

		return $mobileApplicationsLinks;
	}

	/**
	 * Replaces link's %s parameter with proper language parameter
	 *
	 * @param array $mobileApplicationsLinks
	 * @return array with localized links
	 */
	private function localizeLinks( $mobileApplicationsLinks ) {
		$localizedLinks = [];

		if ( !empty( $mobileApplicationsLinks[self::ANDROID_PLATFORM] ) ) {
			$localizedLinks[self::ANDROID_PLATFORM] =
				sprintf( $mobileApplicationsLinks[self::ANDROID_PLATFORM], $this->language );
		}
		if ( !empty( $mobileApplicationsLinks[self::IOS_PLATFORM] ) ) {
			$localizedLinks[self::IOS_PLATFORM] =
				sprintf( $mobileApplicationsLinks[self::IOS_PLATFORM],
					$this->prepareLanguageForAppStore() );
		}

		return $localizedLinks;
	}

	private function prepareLanguageForAppStore() {
		return empty ( self::$appStoreLanguagesMapping[$this->language] ) ? 'us'
			: self::$appStoreLanguagesMapping[$this->language];
	}

}
