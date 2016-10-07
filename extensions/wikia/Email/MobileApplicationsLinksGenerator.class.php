<?php

namespace Email;

use Http;

/**
 * Class MobileApplicationsLinksGenerator
 * @package Email
 */
class MobileApplicationsLinksGenerator {

	const WIKIA_APP_STORE_URL = 'https://itunes.apple.com/us/developer/wikia-inc./id422467077';

	const WIKIA_GOOGLE_PALY_URL = 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.';

	const ANDROID_PLATFORM = 'android';

	const IOS_PLATFORM = 'ios';

	const MOBILE_APPLICATIONS_LINKS_EVICTION_TIME = 24 * 60 * 60; // 24h

	/**
	 * Generate links for mobile applications for current wiki.
	 *
	 * @return array - may contain 0, 1 or 2 links.
	 */
	public function generate() {
		global $wgMemc;

		$mobileApplicationsLinks = false;
//			$wgMemc->get( $this->createCacheKeyForMobileApplicationsLinks() );

		if ( is_bool( $mobileApplicationsLinks ) ) {
			$mobileApplicationsLinks = [];
			$response = $this->fetchMobileApplicationsDetails();

			if ( $response && $this->applicationsExistIn( $response ) ) {
				$mobileApplications = json_decode( $response, true );
				$mobileApplicationsLinks = $this->traverseThrough( $mobileApplications );
			} else {
				$mobileApplicationsLinks[self::ANDROID_PLATFORM] = self::WIKIA_GOOGLE_PALY_URL;
				$mobileApplicationsLinks[self::IOS_PLATFORM] = self::WIKIA_APP_STORE_URL;
			}

			// Even if response is not valid (for example there are some difficulties with mobile applications service)
			// result will be cached to prevent too long delays in email generation
			$wgMemc->set( $this->createCacheKeyForMobileApplicationsLinks(),
				$mobileApplicationsLinks, time() + self::MOBILE_APPLICATIONS_LINKS_EVICTION_TIME );
		}

		return $mobileApplicationsLinks;
	}

	private function createCacheKeyForMobileApplicationsLinks() {
		return wfMemcKey( 'mobileApplicationsLinks' );
	}

	/**
	 * @return string or boolean (because of Http::request)
	 */
	private function fetchMobileApplicationsDetails() {
		// currently it does not matter if Android or iOS value is added, data is returned for both Android and iOS
		return Http::request( 'GET',
			'https://services.wikia.com/mobile-applications/platform/android' );
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
					if ( $app['android_release'] ) {
						$release = $app['android_release'];
						$mobileApplicationsLinks[self::ANDROID_PLATFORM] =
							"https://play.google.com/store/apps/details?id=$release";
					}
					if ( $app['ios_release'] ) {
						$release = $app['ios_release'];
						$mobileApplicationsLinks[self::IOS_PLATFORM] =
							"https://itunes.apple.com/us/app/id$release";
					}
					break;
				}
			}

			if ( !empty( $mobileApplicationsLinks ) ) {
				break;
			}
		}

		return $mobileApplicationsLinks;
	}
}