<?php

class AnalyticsProviderRubiconVulcan implements iAnalyticsProvider {
	const TEMPLATE = 'extensions/wikia/AnalyticsEngine/templates/rubicon_vulcan.mustache';
	const COUNTRIES_VARIABLE = 'wgAdDriverRubiconVulcanCountries';

	public static function isEnabled() {
		global $wgAdDriverEnableRubiconVulcan, $wgShowAds;

		return $wgAdDriverEnableRubiconVulcan
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage();
	}

	public function getSetupHtml( $params = array() ) {
		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( static::isEnabled() ) {
			return \MustacheService::getInstance()->render(
				static::TEMPLATE,
				[ 'wgCountriesVariable' => static::COUNTRIES_VARIABLE ]
			);
		}

		return '<!-- Rubicon Vulcan disabled -->';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
