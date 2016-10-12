<?php

namespace Email;

use Http;

/**
 * Class MobileApplicationsLinksGenerator
 * @package Email
 */
class MobileApplicationsLinksGenerator {

	const MOBILE_APPLICATIONS_ENDPOINT = 'https://services.wikia.com/mobile-applications/platform/android';

	const WIKIA_APP_STORE_URL = 'https://itunes.apple.com/%s/developer/wikia-inc./id422467077';

	const APPLICATION_APP_STORE_URL = 'https://itunes.apple.com/%s/app/id%s';

	const WIKIA_GOOGLE_PLAY_URL = 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=%s';

	const APPLICATION_GOOGLE_PLAY_URL = 'https://play.google.com/store/apps/details?hl=%s&id=%s';

	const ANDROID_PLATFORM = 'android';

	const IOS_PLATFORM = 'ios';

	const MOBILE_APPLICATIONS_LINKS_EVICTION_TIME = 24 * 60 * 60; // 24h

	static private $appStoreLanguagesMapping = [
		'en' => 'us',
		'zh' => 'cn',
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

		return $mobileApplicationsLinks;
	}

	/**
	 * Fills array with wikia mobile application store link if application was not found
	 *
	 * @param array $mobileApplicationsLinks
	 * @return array with links to app store and google play
	 */
	private function fillWithWikiaAccountLinksIfEmpty( $mobileApplicationsLinks ) {
		if ( empty ( $mobileApplicationsLinks[self::ANDROID_PLATFORM] ) ) {
			$mobileApplicationsLinks[self::ANDROID_PLATFORM] =
				$this->generateUrlForWikiaGooglePlay();
		}

		if ( empty( $mobileApplicationsLinks[self::IOS_PLATFORM] ) ) {
			$mobileApplicationsLinks[self::IOS_PLATFORM] = $this->generateUrlForWikiaAppStore();
		}

		return $mobileApplicationsLinks;
	}

	private function generateUrlForWikiaGooglePlay() {
		return sprintf( self::WIKIA_GOOGLE_PLAY_URL, $this->prepareLanguageForGooglePlay() );
	}

	private function prepareLanguageForGooglePlay() {
		return $this->language;
	}

	private function generateUrlForWikiaAppStore() {
		return sprintf( self::WIKIA_APP_STORE_URL, $this->prepareLanguageForAppStore() );
	}

	private function prepareLanguageForAppStore() {
		return empty ( self::$appStoreLanguagesMapping[$this->language] ) ? 'us'
			: self::$appStoreLanguagesMapping[$this->language];
	}

	private function createCacheKeyForMobileApplicationsLinks() {
		return wfMemcKey( 'mobileApplicationsLinks', $this->language );
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
			foreach ( $app['languages'] as $language ) {
				if ( $language['wikia_id'] == $siteId ) {
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
			$release = $app['android_release'];
			$mobileApplicationsLinks[self::ANDROID_PLATFORM] =
				$this->generateUrlForWikiaApplicationOnGooglePlay( $release );
		}
		if ( $app['ios_release'] ) {
			$release = $app['ios_release'];
			$mobileApplicationsLinks[self::IOS_PLATFORM] =
				$this->generateUrlForWikiaApplicationOnAppStore( $release );
		}

		return $mobileApplicationsLinks;
	}

	private function generateUrlForWikiaApplicationOnGooglePlay( $release ) {
		return sprintf( self::APPLICATION_GOOGLE_PLAY_URL, $this->prepareLanguageForGooglePlay(),
			$release );
	}

	private function generateUrlForWikiaApplicationOnAppStore( $release ) {
		return sprintf( self::APPLICATION_APP_STORE_URL, $this->prepareLanguageForAppStore(),
			$release );
	}
}
